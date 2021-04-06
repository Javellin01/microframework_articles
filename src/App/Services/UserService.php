<?php

namespace App\App\Services;

use App\App\Helper\ApplicationHelper;
use App\Domain\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Session\Session;

class UserService
{
    private $repository;
    private $session;
    private $cookie;

    /**
     * UserService constructor.
     */
    public function __construct()
    {
        $this->repository = new UserRepository();
        $this->session = new Session();
    }

    public function signIn(string $login, string $pass): array
    {
        $result = [];
        $user = $this->repository->getBy('login', $login);

        if ($user)
        {
            if (password_verify($pass, $user->getPassword()))
            {
                $this->session->set('userId', $user->getId());
                $result['userId'] = $user->getId();
            }
            else
            {
                $result['error'] = 'Invalid password';
            }
        }
        else {
            $result['error'] = 'User not found';
        }

        return $result;
    }

    public function signOut()
    {
        $user = $this->getUser();
        $user->setRemember('');
        $this->repository->update($user);

        $this->session->clear();
        $cookie = Cookie::create('rememberstring')
            ->withExpires(time() - 3600);

        return $cookie->__toString();
    }

    public function getUser()
    {
        $userId = $this->session->get('userId');

        return $userId ? $this->repository->get($userId) : null;
    }

    public function rememberMe(int $userId): string
    {
        $user = $this->repository->get($userId);
        if ($user)
        {
            $str = ApplicationHelper::randomString();

            $cookie = Cookie::create('rememberstring')
                ->withValue($str);

            $user->setRemember($str);
            $this->repository->update($user);

            return $cookie->__toString();
        }
    }
}