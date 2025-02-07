<?php
namespace App\models;

use App\config\Database;
use App\core\Session;
use PDO;

class User {
    protected $connection;
    private $session;

    public function __construct() {
        $this->connection = Database::connect();
        $this->session = new Session();
        
    }

    public function signup($name, $email, $password) {
        $query = "SELECT id FROM users WHERE email = :email";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->fetch()) {
            return "Email already exists.";
        }

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $query = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);

        return $stmt->execute();
    }

    public function login($email, $password) {
        $query = "SELECT id, name, password FROM users WHERE email = :email";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user && password_verify($password, $user['password'])) {
            $this->session->set('user_id',$user['id']);
            $this->session->set('user_name',$user['name']);
            return true;
        }

        return false;
    }

    public function logout() {
        session_start();
        session_destroy();
    }
}
