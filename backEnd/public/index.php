<?php

use App\core\Router;
use App\core\Database;
use App\core\CorsMiddleWare;

require_once __DIR__ . '/../bootstrap.php';

$corsMiddleWare = new CorsMiddleWare();
$corsMiddleWare->handle();

try {
    $router = new Router();
    $db = Database::getConnexion();
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $method = $_SERVER['REQUEST_METHOD'];

    $router->dispatch($uri, $method);
} catch (Exception $e) {
    $json = json_encode([
        'error' => 'Une erreur est survenue',
        'message' => $e->getMessage()
    ]);
}
