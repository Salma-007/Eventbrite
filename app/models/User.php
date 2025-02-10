<?php
namespace App\models;

use App\config\Database;
use App\Models\BaseModel;
use App\core\Session;
use PDO;

class User {
    protected $connection;
    private $session;
    private $table = 'users';
    private $crud;

    public function __construct() {
        $this->connection = Database::connect();
        $this->crud = new BaseModel();
        $this->session = new Session();
    }

    public function getUsers(){
        $query = "SELECT * FROM $this->table WHERE id_role!=1;";
        $stmt = $this->connection->query($query);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public function setId($id){
        $this->id = $id;
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

    public function getUserIdByEmail($email) {
        $query = "SELECT id FROM users WHERE email = :email";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['id'] : null;
    }
    public function getDefaultRoleId() {
        $query = "SELECT id FROM roles WHERE name = 'participant'";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['id'] : null;
    }

    public function assignRoleToUser($userId, $roleId) {
        $query = "INSERT INTO roles_users (id_user, id_role) VALUES (:id_user, :id_role)";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':id_user', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':id_role', $roleId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function login($email, $password) {
        $query = "SELECT id, name, password FROM users WHERE email = :email";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $this->session->set('user_id', $user['id']);
            $this->session->set('user_name', $user['name']);
            return true;
        }

        return "Invalid email or password.";
    }

    public function logout() {
        $this->session->destroy();
    }
    // delete user 
    public function deleteUser(){
        return $this->crud->deleteRecord($this->table, $this->id);
    }
    // ban user
    public function banUser(){
        $data = [
            'is_banned' => 1
        ];
        return $this->crud->updateRecord($this->table, $data, $this->id);
    }
    // activate user
    public function activateUser(){
        $data = [
            'is_banned' => 0
        ];
        return $this->crud->updateRecord($this->table, $data, $this->id);
    }


}
