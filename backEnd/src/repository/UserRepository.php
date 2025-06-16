<?php

declare(strict_types=1);

namespace App\repository;

use PDO;
use DateTime;
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
            $sql = "INSERT INTO `user` (username, avatar, email, `role`, email_token, is_verified, password, created_at) 
                VALUES (:username, :avatar, :email, :role, :email_token, :is_verified, :password, :created_at)";
            $stmt = $this->pdo->prepare($sql);

            $params = [
                ':username' => $user->getUsername(),
                ':avatar' => $user->getAvatar(),
                ':email' => $user->getEmail(),
                ':role' => json_encode($user->getRole()),
                ':email_token' => $user->getEmailToken(),
                ':is_verified' => (int)$user->getIsVerified(),
                ':password' => $user->getPassword(),
                ':created_at' => $user->getCreatedAt(),
            ];

            return $stmt->execute($params);
        } catch (\PDOException $e) {
            error_log("Erreur SQL: " . $e->getMessage());
            throw new \RuntimeException("Erreur lors de l'enregistrement de l'utilisateur");
        }
    }
    public function findUserByUsername($username): ?User
    {
        $sql = "SELECT * FROM `user` WHERE username = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$username]);

        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        // $data = $stmt->fetch();
        if (!$data) {
            return null;
        }

        $user = new User($data);
        $user->setId((int)$data['id_user']);
        $user->setVerifiedAt((new DateTime())->format('Y:m:d H:i:s'));
        $user->setRole(json_decode($data['role'], true));

        return $user;
    }
    public function findUserByEmail($email): ?User
    {
        $sql = "SELECT * FROM `user` WHERE email = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$email]);

        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        // $data = $stmt->fetch();
        if (!$data) {
            return null;
        }

        $user = new User($data);
        $user->setId((int)$data['id_user']);
        $user->setVerifiedAt((new DateTime())->format('Y:m:d H:i:s'));
        $user->setRole(json_decode($data['role'], true));

        return $user;
    }
    public function findUserByToken($token): ?User
    {
        $sql = "SELECT * FROM `user` WHERE email_token = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$token]);

        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        // $data = $stmt->fetch();
        if (!$data) {
            return null;
        }

        $user = new User($data);
        $user->setId((int)$data['id_user']);
        $user->setVerifiedAt((new DateTime())->format('Y:m:d H:i:s'));
        $user->setRole(json_decode($data['role'], true));

        return $user;
    }

    public function update(User $user): bool
    {
        $stmt = $this->pdo->prepare(
            "UPDATE user SET 
            username = ?, 
            email = ?, 
            role = ?, 
            is_verified = ?, 
            email_token = ?,
            verified_at = ?,
            password = ?,
            avatar = ?
            WHERE id_user = ?"
        );

        return $stmt->execute([
            $user->getUserName(),
            $user->getEmail(),
            json_encode($user->getRole()),
            (int)$user->getisVerified(),
            $user->getEmailToken(),
            $user->getVerifiedAt(),
            $user->getPassword(),
            $user->getAvatar(),
            $user->getId()
        ]);
    }
}
