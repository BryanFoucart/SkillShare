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

    public function findUserById(int|string $id): ?User
    {
        $sql = "SELECT * FROM `user` WHERE id_user = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);

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
            (int)$user->getIsVerified(),
            $user->getEmailToken(),
            $user->getVerifiedAt(),
            $user->getPassword(),
            $user->getAvatar(),
            $user->getId()
        ]);
    }
    /**
     * Trouve un utilisateur par son token de réinitialisation
     * @param string $token
     * @return User|null
     */
    public function findByResetToken(string $token): ?User
    {
        $stmt = $this->pdo->prepare("SELECT * FROM user WHERE reset_token = ?");
        $stmt->execute([$token]);
        $data = $stmt->fetch();
        if (!$data) return null;

        $data['is_verified'] = (bool)$data['is_verified']; // Convertir en booléen
        $user = new User($data);
        $user->setId((int)$data['id']);
        $user->setRole($data['role']);
        $user->setEmailToken($data['email_token']);
        $user->setPassword($data['password']);
        $user->setResetToken($data['reset_token']);
        $user->setResetAt($data['reset_at'] ? new DateTime($data['reset_at']) : null);
        return $user;
    }
}
