<?php

declare(strict_types=1);

namespace App\controller;

use Exception;
use App\core\attribute\Route;

class UserController
{
    #[Route('/api/register', 'POST')]
    public function register()
    {

        $data = json_decode(file_get_contents('php://input'), true);

        if (!$data) throw new Exception('Json invalide');

        echo json_encode([
            'success' => true,
            'message' => 'Inscription réussie ! Veuillez vérifier vos mails.'
        ]);
    }
}
