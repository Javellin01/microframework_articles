<?php

namespace App\App;

use App\App\Services\UserService;
use App\Domain\Entity\User;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\Routing\Loader\YamlFileLoader;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Router;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\TwigFunction;

define('BASEPATH', dirname(__DIR__, 2));

/**
 * Class App
 * @package App\App
 */
class App
{
    private static $instance = null;
    private $request;
    private $requestContext;
    private $router;
    private $twig;
    private $user;

    private function __construct()
    {
        $this->setRequest(Request::createFromGlobals());
        $this->setRequestContext(new RequestContext());
        $this->setRouter();
        $this->setTwig();
        $this->setUser();
    }

    /**
     * @return mixed
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    private function setUser(): void
    {
        $service = new UserService();
        $this->user = $service->getUser();
    }

    /**
     * @return Request
     */
    private function getRequest(): Request
    {
        return $this->request;
    }

    /**
     * @param Request $request
     */
    private function setRequest(Request $request): void
    {
        $this->request = $request;
    }

    /**
     * @return RequestContext
     */
    private function getRequestContext(): RequestContext
    {
        return $this->requestContext;
    }

    /**
     * @param RequestContext $requestContext
     */
    private function setRequestContext(RequestContext $requestContext): void
    {
        $this->requestContext = $requestContext->fromRequest($this->getRequest());
    }

    /**
     */
    private function setRouter(): void
    {
        $fileLocator = new FileLocator([__DIR__]);
        $this->router = new Router(new YamlFileLoader($fileLocator),BASEPATH . '/config/routes.yaml');
    }

    private function setTwig(): void
    {
        $loader = new FilesystemLoader(BASEPATH . '/templates');
        $this->twig = new Environment($loader, [
            'cache' => BASEPATH . '/templates/cache',
            'auto_reload' => true
        ]);

        // custom Twig function for using Router routes in templates
        $function = new TwigFunction('route', function (string $route = '') {
            $route = $this->getRouter()->getRouteCollection()->get($route);
            if ($route) {
                return $route->getPath();
            }

            return '/#';
        });

        $this->twig->addFunction($function);

        $function = new TwigFunction('userProfile', function () {
            $result = [];
            if ($this->getUser()) {
                return $result = [
                    'profileName' => $this->getUser()->getLogin(),
                    'profileLink' => '/#'
                ];
            }

            return $result;
        });

        $this->twig->addFunction($function);
    }

    /**
     * @return callable
     */
    private function defineController(): callable
    {
        return (new ControllerResolver())->getController($this->getRequest());
    }

    /**
     * @param $controller
     * @return array
     */
    private function defineArguments(callable $controller): array
    {
        return (new ArgumentResolver())->getArguments($this->getRequest(), $controller);
    }

    /**
     * @return Router
     */
    public function getRouter(): Router
    {
        return $this->router;
    }

    /**
     * @param string $route
     * @return string
     */
    public function getRoute(string $route): string
    {
        return $this->getRouter()->getRouteCollection()->get($route)->getPath();
    }

    /**
     * @return Environment
     */
    public function getTwig(): Environment
    {
        return $this->twig;
    }


    /**
     * @return App
     */
    public static function getInstance(): App
    {
        if (empty(self::$instance)) {
            self::$instance = new App();
        }

        return self::$instance;
    }

    /**
     *
     */
    public function run(): void
    {
        $matcher = new UrlMatcher($this->getRouter()->getRouteCollection(), $this->getRequestContext());
        try {
            $this->getRequest()
                ->attributes
                ->add($matcher
                    ->match(
                        $this->getRequest()->getPathInfo())
                );

            $controller = $this->defineController();
            $response = call_user_func_array($controller, $this->defineArguments($controller));
            $response->send();
        }
        catch (\Exception $e) {
            dd($e);
        }
    }
}