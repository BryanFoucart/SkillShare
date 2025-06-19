<?php

declare(strict_types=1);

namespace App\controller;

use __PHP_Incomplete_Class;
use DateTime;
use Exception;
use App\model\User;

use App\service\JWTService;
use App\service\MailService;
use App\core\attribute\Route;
use App\repository\UserRepository;
use App\service\FileUploadService;

class UserController
{

    private UserRepository $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository;
    }

    #[Route('/api/login', 'POST')]
    public function login()
    {
        try {

            $data = json_decode(file_get_contents('php://input'), true);
            if (!$data)
                throw new Exception('Json invalide');

            $user = $this->userRepository->findUserByEmail($data['email']);
            if (!$user)
                throw new Exception('Email ou mot de passe incorrect !');
            if (!password_verify($data['password'], $user->getPassword()))
                throw new Exception('Email ou Mot de passe incorrect !');
            if (!$user->getIsVerified())
                throw new Exception('Veuillez vérifier votre email avant de vous connecter !');


            // générer le token JWT 
            $token = JWTService::generate([
                "id_user" => $user->getId(),
                "role" => $user->getRole(),
                "email" => $user->getEmail()
            ]);


            echo json_encode([
                'success' => true,
                'token' => $token,
                'user' => [
                    'avatar' => $user->getAvatar(),
                    'username' => $user->getUsername(),
                    'role' => $user->getRole()
                ]
            ]);
        } catch (Exception $e) {
            error_log('Erreur inscription' . $e->getMessage());
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
    }

    #[Route('/api/register', 'POST')]
    public function register()
    {
        try {

            $data = json_decode(file_get_contents('php://input'), true);
            if (!$data)
                throw new Exception('Json invalide');

            $emailToken = bin2hex(random_bytes(32));


            $userData = [
                'username' => $data['username'] ?? '',
                'email' => $data['email'] ?? '',
                'password' => password_hash($data['password'], PASSWORD_BCRYPT) ?? '',
                'avatar' => $data['avatar'] ?? 'default-avatar.jpg',
                'email_token' => $emailToken,
                // 'role' => $data['role'] ?? '',
            ];

            // création user
            $user = new User($userData);
            $this->verifyUniqueUserEntry($data, $user);
            $user->setCreatedAt((new DateTime())->format('Y-m-d H:i:s'));

            $saved = $this->userRepository->save($user);

            if (!$saved)
                throw new Exception('Erreur lors de la sauvegarde');

            if (!$user->getEmailToken())
                throw new Exception('Erreur lors de la génération du token de vérification');

            MailService::sendEmailVerification($user->getEmail(), $user->getEmailToken());

            echo json_encode([
                'success' => true,
                'message' => 'Inscription réussie ! Veuillez vérifier vos mails.' . json_encode($data)
            ]);
        } catch (Exception $e) {
            error_log('Erreur inscription' . $e->getMessage());
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
    }

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
                'message' => 'Succeed',
                'filename' => $filename
            ]);
        } catch (Exception $e) {
            throw new Exception('Erreur lors de l\'upload du fichier: ' . $e->getMessage());
        }
    }

    #[Route('/api/verify-email', 'GET')]
    public function verifyEmail()
    {
        try {
            $token = $_GET['token'] ?? null;

            if (!$token) {
                throw new Exception('Token manquant !');
            }


            $user = $this->userRepository->findUserByToken($token);

            if (!$user)
                throw new Exception('Utilisateur introuvable');

            $user->setEmailToken(null);
            $user->setIsVerified(true);
            $updated = $this->userRepository->update($user);
            if (!$updated)
                throw new Exception("Erreur lors de la mise à jour de l'utilisateur");
            echo json_encode([
                'success' => true,
                'message' => "Email vérifié avec succès"
            ]);
        } catch (Exception $e) {
            error_log('Erreur inscription' . $e->getMessage());
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
    }

    //     #[Route('/api/user/update', 'POST')]
    //     public function updateProfil()
    //     {
    //         try {
    //             $data = json_decode(file_get_contents('php://input'), true);
    //             if (!$data) throw new Exception('Json invalide');
    //             
    //             // Récupération token
    //             $headers = getallheaders();
    //             $authHeader = $headers['Authorization'] ?? $headers['authorization'] ?? '';

    //             $token = str_replace('Bearer ', '', $authHeader);
    //             if (!$token) throw new Exception('Not authorized');

    //             // Appel du service JWT pour vérifier le token
    //             $verifToken = JWTService::verifyToken($token);
    //             if (!$verifToken) throw new Exception('Token invalide');

    //             $user = $this->userRepository->findUserById($verifToken['id_user']);
    //             if (!$user) throw new Exception('Utilisateur non trouvé');

    //             // mettre à jour les infos utilisateurs
    //             if (isset($data['username'])) $user->setUsername($data['username']);
    //             // si autre champ à modifier
    //             // if (isset($data['firstname'])) $user->setUsername($data['firstname']);

    //             $updated = $this->userRepository->update($user);
    //             if (!$updated) throw new Exception('Problème d\'update utilisateur BDD');
    //             echo json_encode([
    //                 'success' => true,
    //                 'message' => 'Modification effectuée !'
    //             ]);
    //         } catch (Exception $e) {
    //             error_log('Erreur update' . $e->getMessage());
    //             http_response_code(400);
    //             echo json_encode([
    //                 'success' => false,
    //                 'error' => $e->getMessage()
    //             ]);
    //         }
    //     }
    // }

    #[Route('/api/user/update', 'POST')]
    public function updateProfil()
    {
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            if (!$data) {
                throw new Exception('Json invalide');
            }

            // Log des données reçues
            error_log('Données reçues: ' . json_encode($data));


            $headers = getallheaders();
            $authHeader = $headers['Authorization'] ?? $headers['authorization'] ?? '';

            error_log('Auth header: ' . $authHeader); // Log du header d'autorisation

            $token = str_replace('Bearer ', '', $authHeader);
            if (!$token) {
                throw new Exception('Token manquant');
            }

            $verifToken = JWTService::verifyToken($token);
            if (!$verifToken) {
                throw new Exception('Token invalide');
            }

            $user = $this->userRepository->findUserById($verifToken['id_user']);
            if (!$user) {
                throw new Exception('Utilisateur non trouvé');
            }

            $this->verifyUniqueUserEntry($data, $user);

            if (isset($data['username'])) $user->setUsername($data['username']);
            if (isset($data['email'])) $user->setEmail($data['email']);

            // if (isset($data['username'])) {
            //     // Vérifier si le nom d'utilisateur existe déjà
            //     $existingUser = $this->userRepository->findUserByUsername($data['username']);
            //     if ($existingUser && $existingUser->getId() !== $user->getId()) {
            //         throw new Exception('Ce nom d\'utilisateur est déjà pris');
            //     }
            //     $user->setUsername($data['username']);
            // }

            $updated = $this->userRepository->update($user);
            if (!$updated) {
                throw new Exception('Erreur lors de la mise à jour');
            }

            echo json_encode([
                'success' => true,
                'message' => 'Profil mis à jour avec succès'
            ]);
        } catch (Exception $e) {
            error_log('Erreur update: ' . $e->getMessage());
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
    }

    public function verifyUniqueUserEntry(array $data, ?User $currentUser = null): void
    {
        error_log("Validation data: " . json_encode($data));
        error_log("Current user: " . ($currentUser ? $currentUser->getUsername() . " / " . $currentUser->getEmail() : "null"));

        $usernameExists = false;
        $emailExists = false;

        // Check username only if it's provided and different from current user's username
        if (!empty($data['username'])) {
            error_log("Checking username: " . $data['username']);
            if ($currentUser === null || $data['username'] !== $currentUser->getUsername()) {
                error_log("Username is different from current, checking database...");
                $existingUser = $this->userRepository->findUserByUsername($data['username']);
                $usernameExists = $existingUser ? true : false;
                error_log("Username exists: " . ($usernameExists ? "yes" : "no"));
            } else {
                error_log("Username same as current user, skipping check");
            }
        }

        // Same for email...
        if (!empty($data['email'])) {
            error_log("Checking email: " . $data['email']);
            if ($currentUser === null || $data['email'] !== $currentUser->getEmail()) {
                error_log("Email is different from current, checking database...");
                $existingUser = $this->userRepository->findUserByEmail($data['email']);
                $emailExists = $existingUser ? true : false;
                error_log("Email exists: " . ($emailExists ? "yes" : "no"));
            } else {
                error_log("Email same as current user, skipping check");
            }
        }

        // Rest of validation...
    }

    #[Route('/api/user/update-avatar', 'POST')]
    /**
     * Met à jour l'avatar de l'utilisateur
     * Route : POST /api/user/update-avatar
     */
    public function updateAvatar(): void
    {
        try {
            // Récupération token
            $headers = getallheaders();
            $authHeader = $headers['Authorization'] ?? $headers['authorization'] ?? '';

            $token = str_replace('Bearer ', '', $authHeader);
            if (!$token) throw new Exception('Not authorized');


            if (!$token) {
                throw new Exception('Non autorisé');
            }

            $payload = JWTService::verifyToken($token);
            if (!$payload) {
                throw new Exception('Token invalide');
            }

            if (!isset($_FILES['avatar'])) {
                throw new Exception('Aucun fichier envoyé');
            }

            $user = $this->userRepository->findUserById($payload['id_user']);

            if (!$user) {
                throw new Exception('Utilisateur non trouvé');
            }

            // Gérer l'upload de l'avatar
            try {
                $upload_dir = __DIR__ . '../../public/uploads/avatar';
                $avatarFilename = FileUploadService::handleAvatarUpload($_FILES['avatar'], __DIR__ . '/../../public/uploads/avatar/');

                // Supprimer l'ancien avatar si il existe
                if ($user->getAvatar() && $user->getAvatar() !== 'default-avatar.jpg') {
                    FileUploadService::deleteOldAvatar($user->getAvatar(), $upload_dir);
                }

                $user->setAvatar($avatarFilename);
                $updated = $this->userRepository->update($user);

                if (!$updated) {
                    throw new Exception('Erreur lors de la mise à jour');
                }

                echo json_encode([
                    'success' => true,
                    'message' => 'Avatar mis à jour avec succès',
                    'avatar' => $avatarFilename
                ]);
            } catch (Exception $e) {
                throw new Exception('Erreur lors de l\'upload: ' . $e->getMessage());
            }
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
    }
}
