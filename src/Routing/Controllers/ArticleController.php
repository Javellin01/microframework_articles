<?php

namespace App\Routing\Controllers;

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
        $entity = $this->repository->get($id);

        return $this->render('/articles/article', [
            'article' => $entity->getData(),
            'edit' => $this->generateUrl('articles_edit', ['id' => $entity->getId()]),
        ]);
    }

    public function all(): Response
    {
        $result = [];
        $arrEntities = $this->repository->all();

        foreach ($arrEntities as $arrEntity) {
            $result[] = [
                'title' => $arrEntity->getTitle(),
                'open' => $this->generateUrl('articles_get', ['id' => $arrEntity->getId()]),
                'edit' => $this->generateUrl('articles_edit', ['id' => $arrEntity->getId()]),
                'remove' => $this->generateUrl('articles_remove', ['id' => $arrEntity->getId()]),
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

        return $this->render('/articles/edit', [
            'article' => $article->getData(),
            'save' => $this->generateUrl('articles_save')
        ]);
    }

    public function create(Request $request): RedirectResponse
    {
        $id = $this->service->add($request->request->all());

        return $this->redirectToRoute('articles_all');

    }

    public function save(Request $request): RedirectResponse
    {
        $id = $this->service->update($request->request->all());

        return $this->redirectToRoute('articles_all');
    }

    public function remove(int $id): RedirectResponse
    {
        $this->repository->remove($id);

        return $this->redirectToRoute('articles_all');
    }

}