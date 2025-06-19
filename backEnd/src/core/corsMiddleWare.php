<?php

declare(strict_types=1);

namespace App\core;

class CorsMiddleWare
{
    public function handle()
    {
        // Définition de l'origine autorisée
        header('Access-Control-Allow-Origin: http://localhost:3001');
        // Définir les méthodes autorisés
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        // Définir les headers autorisés
        header('Access-Control-Allow-Headers: Content-Type, Authorization');
        // header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
        // Définir le type de contenu par défaut
        header('Content-Type: application/json; charset=utc-8');

        // Gérer les requêtes OPTIONS (pre-flight)
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(200);
            exit();
        }
    }
}
