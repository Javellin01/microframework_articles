<?php


namespace App\Domain\Factory;

use App\Domain\Entity\Article;

class ArticleFactory extends Factory
{
    /**
     * @inheritDoc
     */
    protected function getEntityClass(): string
    {
        return Article::class;
    }
}