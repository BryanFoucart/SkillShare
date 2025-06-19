<?php

declare(strict_types=1);

namespace App\core;

use PDO;
use PDOException;

class Database
{
    private static ?PDO $pdo = null;

    public static function getConnexion(): PDO
    {

        if (self::$pdo === null) {
            $env = $_ENV;
            if (!isset($env['DB_HOST'], $env['DB_NAME'], $env['DB_USER'], $env['DB_PASSWORD'], $env['DB_PORT'])) {
                throw new \RuntimeException('Database envrionment variables not set');
            }
            $host = $env['DB_HOST'];
            $dbName = $env['DB_NAME'];
            $dbUser = $env['DB_USER'];
            $dbPassword = $env['DB_PASSWORD'];
            $dbPort = $env['DB_PORT'];

            try {
                self::$pdo = new PDO("mysql:host=$host;dbname=$dbName;port=$dbPort", $dbUser, $dbPassword, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]);
            } catch (PDOException $pdoEx) {
                die("Erreur de connexion : " . $pdoEx->getMessage());
            }
        }
        return self::$pdo;
    }
}
