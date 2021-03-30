<?php

namespace App\Routing\Controllers;

use App\App\Services\UserService;

class UserController extends BaseController
{
    public function auth()
    {
        $login = 'thislogin';
        $pass = 'thispassword';

        $service = new UserService();
        $user = $service->signIn($login, $pass);

        return $this->json($user);
    }
}