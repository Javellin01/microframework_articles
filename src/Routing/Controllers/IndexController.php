<?php

namespace App\Routing\Controllers;

use App\App\Services\UserService;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 */
class IndexController extends BaseController
{
    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return $this->json(['title' => '123']);
    }

    /**
     * @return JsonResponse
     */
    public function test(): JsonResponse
    {
        $s = new UserService();


        $newsletterManager = $this->container->get('mailer');
        $newsletterManager->send();

        $s->rememberMe(2);
        return $this->json(['title' => '123']);
    }
}