<?php

namespace App\Routing\Controllers;

use App\App\App;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

abstract class BaseController
{
    protected $repository;
    protected $service;
    protected $cookie;
    protected $container;

    /**
     * BaseController constructor.
     * @param $repository
     */
    public function __construct()
    {
        $this->container = App::getInstance()->container();
    }

    /**
     * @param mixed $cookie
     */
    public function setCookie(Cookie $cookie)
    {
        $this->cookie = $cookie;
    }

    protected function render(string $view, array $params = []): Response
    {
        $twig = App::getInstance()->getTwig();

        return new Response($twig->render($view . '.html.twig', $params));
    }

    protected function json($str, int $status = 200, array $headers = []): JsonResponse
    {
        $response = new JsonResponse($str, $status, $headers);
        if (!empty($this->cookie))
        {
            $response->headers->setCookie($this->cookie);
        }

        return $response;
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
        $response = new RedirectResponse(App::getInstance()->getRouter()->generate($route), $status, $headers);
        if (!empty($this->cookie))
        {
            $response->headers->setCookie($this->cookie);
        }

        return $response;
    }
}