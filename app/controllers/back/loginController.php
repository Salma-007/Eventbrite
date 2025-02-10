<?php
namespace App\controllers\back;

use App\core\Controller;
use App\models\User;
use App\core\View;
use App\core\Security;

class loginController extends Controller {
    protected $userModel;

    public function __construct() {
        parent::__construct();
        $this->userModel = new User();
    }

    public function loginPage() {
        View::render('front.login');
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email']);
            $password = $_POST['password'];

            if (empty($email) || empty($password)) {
                View::render('front.login', ['error' => 'Tous les champs sont obligatoires.']);
                return;
            }

            $result = $this->userModel->login($email, $password);

            if ($result) {
                header("Location: /");
                exit;
            } else {
                View::render('front.login', ['error' => 'Email ou mot de passe incorrect.']);
            }
        } else {
            View::render('front.login');
        }
    }
}
