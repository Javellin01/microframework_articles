<?php

namespace App\App\Services;

use App\Domain\Entity\User;
use App\Domain\Repository\UserRepository;

class UserService
{
    private $repository;

    /**
     * UserService constructor.
     */
    public function __construct()
    {
        $this->repository = new UserRepository();
    }

    public function signIn(string $login, string $pass): ?User
    {
        $user = $this->repository->getBy('login', $login);

        $result = null;
        if ($user)
        {
            if (password_verify($pass, $user->getPassword()))
            {
                $result = $user;
                dump($result);
            }
        }

        return $result;
    }

}