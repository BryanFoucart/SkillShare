<?php
require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->safeLoad();

// Récupérer le port depuis .env
$port = $_ENV['PORT'] ?? '8000';

// Récupérer l'URL complète
$host = $_ENV['SITE_URL'] ?? "localhost:{$port}";

// Extrait le host:port de l'URL complète
$parsedUrl = parse_url($host);
$serverHost = $parsedUrl['host'] ?? 'localhost';
// Utiliser le PORT du .env en priorité
$serverPort = $port;

echo "Starting server at {$serverHost}:{$serverPort}\n";
system("php -S {$serverHost}:{$serverPort} -t public");
