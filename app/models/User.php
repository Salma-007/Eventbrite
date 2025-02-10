<?php
namespace App\models;

use App\config\Database;
use App\core\Session;
use PDO;

class User {

        private $id;
        private $name;
        private $email;
        private $password;
        private $role_id;
        private $table = 'users';
        private $crud;
        private $conn;
    
        public function __construct($name = null, $email = null, $password = null, $role_id = null, $id = -1) {
            $this->conn = Database::connect();
            $this->id = $id;
            $this->name = $name;
            $this->email = $email;
            $this->password = $password;
            $this->role_id = $role_id;
            $this->crud = new BaseModel($this->conn);
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
    
        public function setId($id) {
            $this->id = $id;
        }
    
        public function getId() {
            return $this->id;
        }
    
        // public function getConn(){
        //     return $this->conn;
        // }



        //  ajoute user
        public function insertUser() {
            $data = [
                'name' => $this->name,
                'email' => $this->email,
                'password' => $this->password,
                'id_role' => $this->role_id
            ];
            return $this->crud->insertRecord($this->table, $data);
        }
    


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


    public function login($email, $password) {
        $query = "SELECT id, name, password, id_role FROM " . $this->table . " WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Stocker les informations de l'utilisateur dans la session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_role'] = $user['id_role'];
            return true;
        }

        return false;
    }
   
}
