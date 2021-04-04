<?php


namespace App\App\Services;

use App\Domain\Factory\ArticleFactory;
use App\Domain\Repository\ArticleRepository;

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

        return $this->repository->update($new);
    }
}