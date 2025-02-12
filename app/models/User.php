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
    private $conn;

    public function __construct($name = null, $email = null, $password = null, $role_id = null, $id = -1) {
        $this->connection = Database::connect();
        $this->crud = new BaseModel();
        $this->session = new Session();
        $this->conn = $this->connection;
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->role_id = $role_id;
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
    }
    
        public function setName($name) {
            $this->name = $name;
        }
    
        public function getName() {
            return $this->name;
        }
    
        public function setEmail($email) {
            $this->email = $email;
        }
    
        public function getEmail() {
            return $this->email;
        }
    
        public function setPassword($password) {
            $this->password = $password;
        }
    
        public function getPassword() {
            return $this->password;
        }
    
        public function setRoleId($role_id) {
            $this->role_id = $role_id;
        }
    
        public function getRoleId() {
            return $this->role_id;
        }
    
        public function getId() {
            return $this->id;
        }
        //  ajoute user
        public function insertUser() {
            $data = [
                'name' => $this->name,
                'email' => $this->email,
                'password' => $this->password,
                'id_role' => $this->role_id
            ];
            $this->conn->beginTransaction();
            try {
                $this->crud->insertRecord($this->table, $data);
                $this->id = $this->conn->lastInsertId();
                $this->conn->commit();
                return $this->id;
            } catch (Exception $e) {
                $this->conn->rollBack();
                throw $e;
            }        }
        //recuperation users par email
        public function getUserByEmail($id) {
            return $this->crud->getRecordbyName($this->table,'email', $id);
        }
    
        // recuperation tous les user
        public function getAllUsers() {
            return $this->crud->readRecords($this->table);
        }
    
        // recuperation user par id
        public function getUserById() {
            return $this->crud->getRecord($this->table, $this->id);
        }

     // Vérifier si l'email existe déjà
     public function emailExists($email) {
        $query = "SELECT * FROM " . $this->table . " WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC) ? true : false;
    }
  
    // recuperation id de role par leur name
    public function getRoleIdByName($roleName) {
        $query = "SELECT id FROM roles WHERE name = :roleName";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':roleName', $roleName, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['id'] : null;
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
    // count users
    public function getCountUsers(){
        return $this->crud->getTableCount($this->table);
    }

   // assign un role a un utilisateur
    public function assignRoleToUser($userId, $roleId) {
        $query = "INSERT INTO roles_users (id_user, id_role) VALUES (:userId, :roleId)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':roleId', $roleId, PDO::PARAM_INT);
        return $stmt->execute();
    }
  //delet user et leurs role dans table pevot 
    public function removeRoleFromUser($userId, $roleId) {
        $query = "DELETE FROM roles_users WHERE id_user = :userId AND id_role = :roleId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':roleId', $roleId, PDO::PARAM_INT);
        return $stmt->execute();
    }
    // recuperationde roleUsers
    public function getUserRoles($userId) {
        $query = "SELECT r.name FROM roles r JOIN roles_users ru ON r.id = ru.id_role WHERE ru.id_user = :userId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

   
}
