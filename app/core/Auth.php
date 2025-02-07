<?php
namespace App\core;

use App\core\Controller;
use App\models\User;
use App\core\Session;

class Auth extends Controller {
    protected $userModel;
    private $session;

    public function __construct() {
        parent::__construct();
        $this->userModel = new User();
        $this->session = new Session();
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email']);
            $password = $_POST['password'];

            if (empty($email) || empty($password)) {
                $this->render('login', ['error' => 'Tous les champs sont obligatoires.']);
                return;
            }

            $result = $this->userModel->login($email, $password);

            if ($result) {
                header("Location: /");
                exit;
            } else {
                $this->render('login', ['error' => 'Email ou mot de passe incorrect.']);
            }
        } else {
            $this->render('login');
        }
    }

    public function logout() {
        $this->session->destroy(); 
        header('Location: /login');
        exit;
    }
    public function checkLogin() {
        return $this->session->isLoggedIn();
    }
}
