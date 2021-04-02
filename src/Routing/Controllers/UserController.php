<?php

namespace App\Routing\Controllers;

use App\App\App;
use App\App\Services\UserService;

class UserController extends BaseController
{
    public function auth()
    {
        $login = 'thislogin';
        $pass = 'thispassword';

        $service = new UserService();
        $user = $service->signIn($login, $pass);
        dump(UserService::getUser());

        return $this->json($user);
    }
}