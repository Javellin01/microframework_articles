<?php

namespace App\Domain\Repository;

use App\App\App;
use App\Domain\Entity\Article;
use App\Domain\Factory\ArticleFactory;
use App\Domain\Storage\SQLiteStorage;

/**
 * Class ArticleRepository
 * @package App\Domain
 */
class ArticleRepository implements IArticleRepository
{
    const ENTITY = 'articles';
    protected $storage;

    /**
     * ArticleRepository constructor.
     */
    public function __construct()
    {
        $this->storage = new SQLiteStorage();
    }


    /**
     * @param int $id
     * @return Article|null
     */
    public function get(int $id): ?Article
    {
        $article = null;
        $queryResult = $this->storage->find(self::ENTITY, $id);
        if ($queryResult)
        {
            $article = ArticleFactory::createFromArray($queryResult);
        }

        return ($article instanceof Article) ? $article : null;
    }

    /**
     * @return array
     */
    public function all(): array
    {
        $queryResult = $this->storage->findAll(self::ENTITY);
        $result = [];

        foreach ($queryResult as $resItem) {
            $result[] = ArticleFactory::createFromArray($resItem);
        }

        return $result;
    }

    public function mine(string $field, string $value): array
    {
        $queryResult = $this->storage->findGroupBy(self::ENTITY, $field, $value);
        $result = [];

        foreach ($queryResult as $resItem) {
            $result[] = ArticleFactory::createFromArray($resItem);
        }

        return $result;
    }

    /**
     * @param Article $article
     * @return mixed
     */
    public function add(Article $article)
    {
        $article->setAuthor(App::getInstance()->getUser()->getId());

        return $this->storage->create(self::ENTITY, $article);
    }

    /**
     * @param Article $article
     * @return mixed
     */
    public function update(Article $article)
    {
        $current = $this->storage->find(self::ENTITY, $article->getId());
        $article->setAuthor($current['author']);

        return $this->storage->update(self::ENTITY, $article);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function remove(int $id)
    {
        return $this->storage->delete(self::ENTITY, $id);
    }
}