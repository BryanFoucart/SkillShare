<?php

declare(strict_types=1);

namespace App\model;

use DateTime;

class User
{
    private int $id;
    private string $username;
    private string $avatar = "default-avatar.jpg";
    private string $email;
    private array $role = ["ROLE_USER"];
    private string $password;
    private string $created_at;
    private ?string $email_token;
    private bool $is_verified;
    private string $verified_at;

    private ?string $reset_at = null;
    private ?string $reset_token = null;

    public function __construct(array $data)
    {
        $this->username = $data['username'];
        $this->email = $data['email'];
        $this->password = $data['password'];
        $this->avatar = $data['avatar'] ?? $this->avatar;
        $this->email_token = $data['email_token'];
        $this->is_verified = isset($data['is_verified']) ? (bool)$data['is_verified'] : false;
    }

    public function getId(): int
    {
        return $this->id;
    }
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getUsername(): string
    {
        return $this->username;
    }
    public function setUsername(string $username): self
    {
        $this->username = $username;
        return $this;
    }

    public function getAvatar(): string
    {
        return $this->avatar;
    }
    public function setAvatar(string $avatar): self
    {
        $this->avatar = $avatar;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getRole(): array
    {
        return $this->role;
    }
    public function setRole(array $role): self
    {
        $this->role = $role;
        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    public function getCreatedAt(): string
    {
        return $this->created_at;
    }
    public function setCreatedAt(string $created_at): self
    {
        $this->created_at = $created_at;
        return $this;
    }

    public function getEmailToken(): ?string
    {
        return $this->email_token;
    }
    public function setEmailToken(?string $email_token): self
    {
        $this->email_token = $email_token;
        return $this;
    }

    public function getIsVerified(): bool
    {
        return $this->is_verified;
    }
    public function setIsVerified(bool $is_verified): self
    {
        $this->is_verified = $is_verified;
        return $this;
    }

    public function getVerifiedAt(): string
    {
        return $this->verified_at;
    }
    public function setVerifiedAt(string $verified_at): self
    {
        $this->verified_at = $verified_at;
        return $this;
    }

    public function getResetAt(): ?string
    {
        return $this->reset_at;
    }
    public function setResetAt(?string $reset_at): self
    {
        $this->reset_at = $reset_at;
        return $this;
    }

    public function getResetToken(): ?string
    {
        return $this->reset_token;
    }
    public function setResetToken(?string $reset_token): self
    {
        $this->reset_token = $reset_token;
        return $this;
    }
}
