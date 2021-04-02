<?php

namespace App\Routing\Controllers;

use App\App\App;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 */
class IndexController extends AbstractController
{
    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return $this->json(['title' => '']);
    }
}