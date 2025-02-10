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

    public function signup($name, $email, $hashedPassword) {
        
        $query = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->fetch()) {
            return "Email already exists.";
        }
        $defaultRoleQuery = "SELECT id FROM roles WHERE name = 'participant'";
        $defaultRoleStmt = $this->connection->prepare($defaultRoleQuery);
        $defaultRoleStmt->execute();
        $defaultRole = $defaultRoleStmt->fetch(PDO::FETCH_ASSOC);

        if (!$defaultRole) {
            return "Default role not found.";
        }

        $id_role = $defaultRole['id'];


        $query = "INSERT INTO users (name, email, password, id_role) VALUES (:name, :email, :password, :id_role)";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
        $stmt->bindParam(':id_role', $id_role, PDO::PARAM_INT);


        if ($stmt->execute()) {
            return true;
        } else {
            // Débogage : Vérifiez les erreurs de la base de données
            error_log("Database error: " . print_r($stmt->errorInfo(), true));
            return "Failed to create user.";
        }
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

        return "Invalid email or password.";
    }

    public function logout() {
        $this->session->destroy();
    }
}
