<?php

namespace App\Routing\Controllers;

use App\App\App;
use App\App\Services\ArticleService;
use App\Domain\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ArticleController extends BaseController
{
    public function __construct()
    {
        $this->repository = new ArticleRepository();
        $this->service = new ArticleService();
    }

    public function index()
    {
        return $this->render('/articles/index');
    }

    public function get(int $id): Response
    {
        $article = $this->repository->get($id);
        if ($article)
        {
            $params = [
                'article' => $article->getData(),
            ];

            if ($this->service->canEdit($article)) {
                $params['edit'] = $this->generateUrl('articles_edit', ['id' => $article->getId()]);
                $params['remove'] = $this->generateUrl('api/articles_remove', ['id' => $article->getId()]);
            }
        }

        else
        {
            $params = ['errors' => 'No such article'];
        }

        return $this->render('/articles/article', $params);
    }

    public function all(): Response
    {
        $result = [];
        $arrEntities = $this->repository->all();

        foreach ($arrEntities as $arrEntity) {
            $resItem = [
                'title' => $arrEntity->getTitle(),
                'open' => $this->generateUrl('articles_get', ['id' => $arrEntity->getId()]),
            ];

            if ($this->service->canEdit($arrEntity))
            {
                $resItem['edit'] = $this->generateUrl('articles_edit', ['id' => $arrEntity->getId()]);
                $resItem['remove'] = $this->generateUrl('api/articles_remove', ['id' => $arrEntity->getId()]);
            }

            $result[] = $resItem;
        }

        return $this->render('/articles/all', ['articles' => $result]);
    }

    public function my(): Response
    {
        $result = [];

        $arrEntities = $this->repository->mine(
            'author',
            App::getInstance()->getUser()->getId()
        );

        foreach ($arrEntities as $arrEntity) {
            $result[] = [
                'title' => $arrEntity->getTitle(),
                'open' => $this->generateUrl('articles_get', ['id' => $arrEntity->getId()]),
                'edit' => $this->generateUrl('articles_edit', ['id' => $arrEntity->getId()]),
                'remove' => $this->generateUrl('api/articles_remove', ['id' => $arrEntity->getId()]),
            ];
        }

        return $this->render('/articles/all', ['articles' => $result]);
    }

    public function new(): Response
    {
        return $this->render('/articles/new', ['save' => $this->generateUrl('articles_create')]);
    }

    public function edit(Request $request): Response
    {
        $id = $request->attributes->get('id');
        $article = $this->repository->get($id);

        if (!$this->service->canEdit($article))
        {
            return $this->json('403 Forbidden', 403);
        }

        return $this->render('/articles/edit', [
            'article' => $article->getData(),
            'save' => $this->generateUrl('api/articles_save')
        ]);
    }

    public function create(Request $request): RedirectResponse
    {
        $params = $request->request->all();
        $id = $this->service->add($params);

        return $this->redirectToRoute('articles_all');
    }

    public function save(Request $request): RedirectResponse
    {
        $params = $request->request->all();
        $id = $this->service->update($params);

        return $this->redirectToRoute('articles_all');
    }

    public function remove(int $id): RedirectResponse
    {
        $this->service->remove($id);

        return $this->redirectToRoute('articles_all');
    }

}