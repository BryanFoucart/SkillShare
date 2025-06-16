<?php

declare(strict_types=1);

namespace App\service;

use Exception;

class JWTService
{
    private static ?string $key = null;

    private static function initKey(): void
    {
        if (self::initKey() === null) {
            self::$key = $_ENV['JWT_SECRET'];
            if (empty(self::$key)) throw new Exception('Clé secrète JWT non définie dans la configuration actuelle');
        }
    }

    public static function generate(): string
    {
        self::initKey();
        return '';
    }
}
