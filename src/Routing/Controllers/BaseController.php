<?php

namespace App\Routing\Controllers;

use App\App\App;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

abstract class BaseController
{
    protected $repository;
    protected $service;

    protected function render(string $view, array $params = [])
    {
        $twig = App::getInstance()->getTwig();

        return new Response($twig->render($view . '.html.twig', $params));
    }

    protected function json($str, int $status = 200, array $headers = []): JsonResponse
    {
        return new JsonResponse($str, $status, $headers);
    }

    protected function generateUrl(string $route, array $params = []): string
    {
        return App::getInstance()->getRouter()->generate($route, $params);
    }

    protected function redirect(string $uri): RedirectResponse
    {
        return new RedirectResponse($uri);
    }

    protected function redirectToRoute(string $route, int $status = 302, array $headers = []): RedirectResponse
    {
        return new RedirectResponse(App::getInstance()->getRouter()->generate($route), $status, $headers);
    }
}