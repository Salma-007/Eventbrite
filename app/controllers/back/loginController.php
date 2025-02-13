<?php
namespace App\controllers\back;

use App\core\Controller;
use App\models\User;
use App\core\View;
use App\core\Security;
use App\core\Auth;
use App\core\Session;


class loginController extends Controller {
    protected $userModel;

    public function __construct() {
        parent::__construct();
        $this->Auth = new Auth();
        $this->session = new Session();

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


            $result = $this->Auth->login($email, $password);
            
            if ($result) {
            $userRole = $this->session->get('user_role');
            switch ($userRole) {
                case '1':
                    header("Location: /dashboard");
                    break;
                case 'organisateur':
                    header("Location: /accueil");
                    break;
                case 'participant':
                    header("Location: /accueil");
                    break;
                default:
                    header("Location: /accueil");
                    break;
            }
            exit;
        } else {
            View::render('front.login', ['error' => 'Email ou mot de passe incorrect.']);
        }
    } else {
            View::render('front.login');
        }
    }
}
