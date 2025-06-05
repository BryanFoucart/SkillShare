<?php
require_once __DIR__ . "/../vendor/autoload.php";

// Load environment variables from .env file
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/../");
$dotenv->safeLoad(); // Use safeLoad to avoid errors if .env doesn't exist

// Define a base URL.
// getenv() will now pick up values from .env if SITE_URL is defined there.
define("SITE_URL", getenv("SITE_URL") ?: "");

$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . "/../templates");
$twig = new \Twig\Environment($loader, [
    // 'cache' => __DIR__ . '/../cache/twig',
    'debug' => true,
]);

if ($twig->isDebug()) {
    $twig->addExtension(new \Twig\Extension\DebugExtension());
}

$twig->addGlobal("site_url", SITE_URL);

$request_uri = $_SERVER["REQUEST_URI"];
$base_path = "";
$route = str_replace($base_path, "", $request_uri);
$route = strtok($route, "?");

switch ($route) {
    case "/":
    case "":
        echo $twig->render("pages/home.twig", ["title" => "Accueil"]);
        break;
    case "/inscription":
        echo $twig->render("pages/placeholder.twig", ["title" => "Inscription", "page_name" => "Inscription"]);
        break;
    case "/connexion":
        echo $twig->render("pages/placeholder.twig", ["title" => "Connexion", "page_name" => "Connexion"]);
        break;
    case "/competences":
        echo $twig->render("pages/placeholder.twig", ["title" => "Compétences", "page_name" => "Compétences"]);
        break;
    default:
        http_response_code(404);
        echo $twig->render("pages/404.twig", ["title" => "Page non trouvée"]);
        break;
}

?>
