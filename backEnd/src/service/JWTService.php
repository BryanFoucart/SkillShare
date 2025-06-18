<?php

declare(strict_types=1);

namespace App\service;

use Exception;

class JWTService
{
    private static ?string $key = null;

    private static function initKey(): void
    {
        if (self::$key === null) {
            self::$key = $_ENV['JWT_SECRET_KEY'] ?? '';
            if (empty(self::$key)) throw new Exception('Clé secrète JWT non définie dans la configuration actuelle');
        }
    }

    public static function generate(array $payload): string
    {
        self::initKey();

        // header
        $header = [
            'type' => 'JWT',
            'alg' => 'HS256'
        ];

        // payload avec expiration 24h
        $payload['exp'] = time() + (24 * 60 * 60);
        // $payload['exp'] = time() + (30); // test token

        //encoder header et payload
        $base64Header = self::base64url_encode(json_encode($header));
        $base64Payload = self::base64url_encode(json_encode($payload));

        // Création de la signature

        $signature = hash_hmac('sha256', $base64Header . '.' . $base64Payload, self::$key, true);
        $base64Signature = self::base64url_encode($signature);


        return $base64Header . '.' . $base64Payload . '.' . $base64Signature;
    }

    private static function base64url_encode(string $data): string
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    private static function base64url_decode(string $data)
    {
        return base64_decode(strtr($data, '-_', '+/'));
    }

    public static function verifyToken(string $token)
    {
        self::initKey();



        // séparer les 3 parties du token
        $parts = explode('.', $token);
        if (count($parts) !== 3) {
            return false;
        }

        [$base64Header, $base64Payload, $base64Signature] = $parts;

        // recréer la signature pour vérification
        $signature = hash_hmac('sha256', $base64Header . '.' . $base64Payload, self::$key, true);

        if (!hash_equals(self::base64url_encode($base64Signature), $signature)) return false;
        // decoder le payload
        $payload = json_decode(self::base64url_decode($base64Payload), true);

        if (isset($payload['exp']) && $payload['exp'] <  time()) return false;

        return $payload;
    }
}
