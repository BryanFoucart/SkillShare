<?php

declare(strict_types=1);

namespace App\core;

use App\core\attribute\Route;
use ReflectionClass;


class RouteResolver
{
    public static function getRoutes(): array
    {

        $routes = [];
        $controllersPath = __DIR__ . '/../controller/';
        $controllerFiles = glob($controllersPath . '/*Controller.php');
        foreach ($controllerFiles as $controllerFile) {
            $className = 'App\\Controller\\' . basename($controllerFile, '.php');
            $reflection = new ReflectionClass($className);

            foreach ($reflection->getMethods() as $method) {
                $attributes = $method->getAttributes(Route::class);

                foreach ($attributes as $attribute) {
                    $route = $attribute->newInstance();
                    $routes[$route->method][$route->path] = [
                        $className,
                        $method->getName()
                    ];
                }
            }
        }
        return $routes;
    }
}
