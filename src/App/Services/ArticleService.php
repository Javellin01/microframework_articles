<?php


namespace App\App\Services;

use App\App\App;
use App\Domain\Entity\Article;
use App\Domain\Factory\ArticleFactory;
use App\Domain\Repository\ArticleRepository;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class ArticleService
{
    private $repository;

    /**
     * UserService constructor.
     */
    public function __construct()
    {
        $this->repository = new ArticleRepository();
    }

    public function add(array $params)
    {
        $new = ArticleFactory::createFromArray($params);

        return $this->repository->add($new);
    }

    public function update(array $params)
    {
        $new = ArticleFactory::createFromArray($params);
        if (!$this->canEdit($new))
        {
            throw new AccessDeniedHttpException();
        }

        return $this->repository->update($new);
    }

    public function remove(int $id)
    {
        $article = $this->repository->get($id);

        if ($this->canEdit($article))
        {
            $this->repository->remove($id);
        }
    }

    public function canEdit(Article $article): bool
    {
        if ($article->getAuthor() === App::getInstance()->getUser()->getId() || App::getInstance()->getUser()->checkPrivileges())
        {
            return true;
        }

        return false;
    }
}