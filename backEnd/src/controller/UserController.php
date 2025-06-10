<?php

declare(strict_types=1);

namespace App\controller;

use App\core\attribute\Route;

class UserController
{
    #[Route('/api/register', 'POST')]
    public function register()
    {
        echo json_encode([
            'success' => true,
            'message' => 'Inscription réussie ! Veuillez vérifier vos mails.'
        ]);
    }
}
