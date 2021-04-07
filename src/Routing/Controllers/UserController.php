<?php

namespace App\Routing\Controllers;

use App\App\App;
use App\App\Services\UserService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
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
        if (App::getInstance()->getUser())
        {
            return $this->redirectToRoute('index');
        }

        return $this->render('/auth/signin', []);
    }

    public function signIn(Request $request): JsonResponse
    {
        $headers = [];
        if (empty($request->request->get('username')) || empty($request->request->get('password'))) {
            $result['error'] = 'Invalid form data';

            return $this->json($result, 400);
        }

        $result = $this->service->signIn($request->request->get('username'), $request->request->get('password'),);
        if (empty($result['error']))
        {
            $result['success'] = true;
            $result['redirectTo'] = App::getInstance()->getRoute('articles_all');
            if (!empty($request->request->get('remember-me'))) {
                $this->setCookie($this->service->rememberMe($result['userId']));
            }
        }
        else {
            $result['success'] = false;
        }

        return $this->json($result, 200, $headers);
    }

    public function signOut(): RedirectResponse
    {
        $this->setCookie($this->service->signOut());

        return $this->redirectToRoute('articles_all');
    }
}