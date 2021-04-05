<?php

namespace App\Domain\Factory;
use App\Domain\Entity\User;

class UserFactory extends Factory
{

    /**
     * @inheritDoc
     */
    protected function getEntityClass()
    {
        return User::class;
    }
}