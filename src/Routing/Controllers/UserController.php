<?php

namespace App\Routing\Controllers;

use App\App\Services\UserService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends BaseController
{
    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $this->service = new UserService();
    }

    public function auth(): Response
    {
        return $this->render('/auth/signin', []);
    }

    public function signIn(Request $request): JsonResponse
    {
        $result = $this->service->signIn(
            $request->request->get('username'),
            $request->request->get('password'),
        );
        empty($result['error']) ? $result['success'] = true : $result['success'] = false;

        return $this->json($result);
    }
}