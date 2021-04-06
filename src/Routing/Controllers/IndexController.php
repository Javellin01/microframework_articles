<?php

namespace App\Routing\Controllers;

use App\App\App;
use App\App\Services\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

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
        $s->rememberMe(2);
        return $this->json(['title' => '123']);
    }
}