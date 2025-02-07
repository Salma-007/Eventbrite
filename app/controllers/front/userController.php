<?php
namespace App\controllers\front;

use App\core\Controller;
use App\models\User;

class UserController extends Controller {
    protected $userModel;

    public function __construct() {
        parent::__construct();
        $this->userModel = new User();
    }

    public function loginPage(){
        $this->render('login');
    }

    public function signupPage(){
        $this->render('signup');
    }

    public function signup() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name']);
            $email = trim($_POST['email']);
            $password = $_POST['password'];

            if (empty($name) || empty($email) || empty($password)) {
                $this->render('signup', ['error' => 'Tous les champs sont obligatoires.']);
                return;
            }

            $result = $this->userModel->signup($name, $email, $password);

            if ($result === true) {
                $this->render("login");
                exit;
            } else {
                $this->render('signup', ['error' => $result]);
            }
        } else {
            $this->render('signup');
        }
    }
    public function homePage() {
        $isLoggedIn = $this->session->isLoggedIn();
        $this->render('home', ['isLoggedIn' => $isLoggedIn]);
    }
    

}
