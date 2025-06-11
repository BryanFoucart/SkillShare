<?php

declare(strict_types=1);

namespace App\controller;

use DateTime;
use Exception;
use App\model\User;

use App\core\attribute\Route;
use App\repository\UserRepository;
use App\service\FileUploadService;

class UserController
{
    #[ROUTE('/api/upload-avatar', 'POST')]
    public function uploadAvatar()
    {
        if (!isset($_FILES['avatar'])) {
            throw new Exception('Aucun fichier envoyé');
        }

        try {
            // Vérification du fichier
            $filename = FileUploadService::handleAvatarUpload($_FILES['avatar'], __DIR__ . '/../../public/uploads/avatar/');

            // if ($user->getAvatar() !== 'default-avatar.jpg') {
            //     FileUploadService::deleteOldAvatar($user->getAvatar());
            // }

            echo json_encode([
                'success' => true,
                'message' => $filename
            ]);
        } catch (Exception $e) {
            throw new Exception('Erreur lors de l\'upload du fichier: ' . $e->getMessage());
        }
    }


    #[Route('/api/register', 'POST')]
    public function register()
    {

        $data = json_decode(file_get_contents('php://input'), true);
        if (!$data) throw new Exception('Json invalide');

        $userData = [
            'username' => $data['username'] ?? '',
            'email' => $data['email'] ?? '',
            'password' => password_hash($data['password'], PASSWORD_BCRYPT) ?? '',
            'avatar' => $data['avatar'] ?? __DIR__ . '/uploads/avatar/default-avatar.jpg',
            // 'role' => $data['role'] ?? '',
        ];

        // création user
        $user = new User($userData);
        $user->setCreatedAt((new DateTime())->format('Y-m-d H:i:s'));
        $userRepository = new UserRepository();
        $saved = $userRepository->save($user);

        if (!$saved) throw new Exception('Erreur lros de la sauvegarde');

        echo json_encode([
            'success' => true,
            'message' => 'Inscription réussie ! Veuillez vérifier vos mails.' . json_encode($data)
        ]);
    }
}
