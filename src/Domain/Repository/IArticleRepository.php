<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Article;

interface IArticleRepository
{
    public function get(int $id);

    public function all();

    public function add(Article $article);

    public function update(Article $article);

    public function remove(int $id);
}