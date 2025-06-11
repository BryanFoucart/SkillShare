<?php

declare(strict_types=1);

namespace App\repository;

use PDO;
use App\model\User;
use App\core\Database;

class UserRepository
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::getConnexion();
    }

    public function save(User $user)
    {
        // requête préparé
        try {
            $sql = "INSERT INTO `user` (username, avatar, email, `role`, password_hash, created_at) 
                VALUES (:username, :avatar, :email, :role, :password_hash, :created_at)";
            $stmt = $this->pdo->prepare($sql);

            $role = $user->getRole();
            if (!is_string($role)) {
                $role = json_encode($role);
            }

            $params = [
                ':username' => $user->getUsername(),
                ':avatar' => $user->getAvatar(),
                ':email' => $user->getEmail(),
                ':role' => $role,
                ':password_hash' => $user->getPassword(),
                ':created_at' => $user->getCreatedAt(),
            ];

            return $stmt->execute($params);
        } catch (\PDOException $e) {
            error_log("Erreur SQL: " . $e->getMessage());
            throw new \RuntimeException("Erreur lors de l'enregistrement de l'utilisateur");
        }
    }
}
