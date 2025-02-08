<?php

namespace App\config;

use PDO;
use PDOException;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

class Database {
    private static $connection = null;

    private function __construct() {}

    public static function connect() {
        if (self::$connection === null) {
            try {
                self::$connection = new PDO(
                    "mysql:host=" . $_ENV['HOST'] . ";dbname=" . $_ENV['DATABASE'],
                    $_ENV['USERNAME'],
                    $_ENV['PASSWORD']
                );
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                echo "connected successfully";
            } catch (PDOException $error) {
                die("Connection failed: " . $error->getMessage());
            }
        }
        return self::$connection;
    }
}
Database::connect();
