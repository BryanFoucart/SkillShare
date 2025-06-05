<?php

declare(strict_types=1);

namespace App\core;

class router
{
    private array $routes;

    public function __construct()
    {
        $this->routes = routeResolver::getRoutes();
    }
}
