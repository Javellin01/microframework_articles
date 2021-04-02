<?php

namespace App\Routing\Controllers;

use App\App\App;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

abstract class BaseController
{
    protected $repository;

    protected function render(string $view, array $params = [])
    {
        $twig = App::getInstance()->getTwig();

        return new Response($twig->render($view . '.html.twig', $params));
    }

    protected function json($str): JsonResponse
    {
        return new JsonResponse($str);
    }

    protected function generateUrl(string $route, array $params = []): string
    {
        return App::getInstance()->getRouter()->generate($route, $params);
    }

    protected function redirect(string $uri): RedirectResponse
    {
        return new RedirectResponse($uri);
    }

    protected function redirectToRoute(string $route): RedirectResponse
    {
        return new RedirectResponse(App::getInstance()->getRouter()->generate($route));
    }

    protected final function checkAccess()
    {
//        $session = new Session();
//        dump($session->get('foo'));
//        $session->remove('foo');
    }
}