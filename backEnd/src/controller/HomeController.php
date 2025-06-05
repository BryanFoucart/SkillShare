<?php

declare(strict_types=1);

namespace App\controller;

use App\core\attribute\Route;

class HomeController
{
    #[Route('/', 'GET')]
    function homeView()
    {
        echo 'home';
    }
}
