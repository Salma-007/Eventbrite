<?php
namespace App\core;

use App\core\Controller;
use App\models\User;
use App\core\Session;
use PDO;


class Auth extends Controller {
    protected $userModel;
    private $session;
    private $conn;

    public function __construct() {
        parent::__construct();
        $this->userModel = new User();
        $this->session = new Session();
    }


    public function logout() {
        $this->session->destroy(); 
        header('Location: /login');
        exit;
    }
    public function checkLogin() {
        return $this->session->isLoggedIn();
    }

    
    public function login($email, $password) {
        $conn = $this->userModel->getConn();
        if (!$conn) {
            throw new Exception("Database connection failed.");
        }

        $query = "SELECT id, name, password FROM users WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
             
        if ($user && password_verify($password, $user['password'])) {
            // Stocker les informations de l'utilisateur dans la session
            $this->session->set('user_id', $user['id']);
            $this->session->set('user_name', $user['name']);
            $this->session->set('user_role', $user['id_role']);
            return true;
        }

        return false;

    
}
}