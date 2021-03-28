<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Article;
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
     * @return Article
     */
    public function get(int $id): Article
    {
        $queryResult = $this->storage->find(self::ENTITY, $id);

        $result = new Article();
        $result
            ->setId($queryResult->id)
            ->setTitle($queryResult->title)
            ->setText($queryResult->text);

        return $result;
    }

    /**
     * @return array
     */
    public function all(): array
    {
        $queryResult = $this->storage->findAll(self::ENTITY);
        $result = [];

        foreach ($queryResult as $resItem) {
            $article = new Article();
            $article
                ->setId($resItem->id)
                ->setTitle($resItem->title)
                ->setText($resItem->text);
            $result[] = $article;
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