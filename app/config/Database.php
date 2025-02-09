<?php

namespace App\config;

use PDO;
use PDOException;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ , '/../../.env');
$dotenv->load();

class Database 
{
    private static $conn = null;

    private function __construct() {}

    private static function getInstance() : Database
    {
        if(self::$conn === null) {
            return new Database;
        }

        return self::$conn;
    }

    public static function connect() 
    {
        if(self::$conn === null) {
            try {
                self::$connection = new PDO(
                    "mysql:host=" . $_ENV['HOST'] . ";dbname=" . $_ENV['DATABASE'],
                    $_ENV['USERNAME'],
                    $_ENV['PASSWORD']
                );
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                // echo "connected successfully";
            } catch (PDOException $error) {
                die("Connection failed: " . $error->getMessage());
            }
        }
        return self::$conn;
    }
}
// Database::connect();
