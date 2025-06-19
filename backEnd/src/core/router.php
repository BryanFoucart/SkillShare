<?php

declare(strict_types=1);

namespace App\core;

use Exception;

class Router
{
    private array $routes;

    public function __construct()
    {
        $this->routes = RouteResolver::getRoutes();
    }

    public function dispatch(string $uri, string $method)
    {
        if (!isset($this->routes[$method][$uri])) {
            throw new Exception("Route not found for {$method} {$uri}");
        }

        [$controllerClass, $action] = $this->routes[$method][$uri];
        $controller = new $controllerClass();
        $controller->$action();
    }
}
