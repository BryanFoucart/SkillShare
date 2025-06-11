<?php

declare(strict_types=1);

namespace App\core;

class CorsMiddleWare
{
    public function handle()
    {
        header('Access-Control-Allow-Origin: http://localhost:3000');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type');

        // Gérer les requêtes OPTIONS (pre-flight)
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            exit(0);
        }
    }
}
