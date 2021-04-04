<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Article;
use App\Domain\Factory\ArticleFactory;
use App\Domain\Storage\MySQLStorage;

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
        $this->storage = new MySQLStorage();
    }

    /**
     * @param int $id
     */
    public function get(int $id): object
    {
        $queryResult = $this->storage->find(self::ENTITY, $id);

        return ArticleFactory::createFromArray($queryResult);
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

    /**
     * @param Article $article
     * @return mixed
     */
    public function add(Article $article)
    {
        return $this->storage->create(self::ENTITY, $article);
    }

    /**
     * @param Article $article
     * @return mixed
     */
    public function update(Article $article)
    {
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