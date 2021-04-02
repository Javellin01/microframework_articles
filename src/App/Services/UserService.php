<?php

namespace App\App\Services;

use App\App\App;
use App\Domain\Entity\User;
use App\Domain\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Session\Session;

class UserService
{
    private $repository;
    private $session;

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

        if ($user)
        {
            if (password_verify($pass, $user->getPassword()))
            {
                $this->session->set('userId', $user->getId());

                return $user;
            }
        }

        return null;
    }

    public static function getUser()
    {
//        $userId = $this->session()
    }
}