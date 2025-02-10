<?php
namespace App\controllers\back;

use App\core\Controller;
use App\models\User;
use App\core\View;
use App\core\Security;

class signupController extends Controller {
    protected $userModel;

    public function __construct() {
        parent::__construct();
        $this->userModel = new User();
    }

    public function signupPage() {
        View::render('front.signup');
    }

    public function signup() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // error_log("Signup method called");
            // var_dump($_POST);

            // var_dump($_SERVER['REQUEST_METHOD'] === 'POST');
            $name = Security::sanitizeInput(trim($_POST['username']));
            // var_dump($name);
            $email = Security::sanitizeInput(trim($_POST['email']));
            // var_dump($email);
            $password = $_POST['password'];
            $confirmPassword = $_POST['confirm_pass'];

            // error_log("Name: $name, Email: $email, Password: $password, Confirm Password: $confirmPassword");


            if (empty($name) || empty($email) || empty($password) || empty($confirmPassword)) {
                View::render('front.signup', ['error' => 'Tous les champs sont obligatoires.']);
                return;
            }

            if (!Security::validateEmail($email)) {
                View::render('front.signup', ['error' => 'Adresse email invalide.']);
                return;
            }
            if (!Security::validatePassword($password)) {
                View::render('front.signup', ['error' => 'Le mot de passe doit contenir au moins 8 caractères.']);
                return;
            }
            if (!Security::confirmPassword($password, $confirmPassword)) {
                View::render('front.signup', ['error' => 'Les mots de passe ne correspondent pas.']);
                return;
            }
            
            if ($this->userModel->emailExists($email)) {
                View::render('front.signup', ['error' => 'Cet email est déjà utilisé.']);
                return;
            }
            
            // Hasher le mot de passe
            $hashedPassword = Security::hashPassword($password);
           

            // Enregistrer l'utilisateur
            $this->userModel->setName($name);
            $this->userModel->setEmail($email);
            $this->userModel->setPassword($hashedPassword);

            // definir le role defaut 
            $defaultRoleName = 'participant';
            $roleId = $this->userModel->getRoleIdByName($defaultRoleName);
            $this->userModel->setRoleId($roleId);

            
             //pour enregistre leurs role par users
            $result = $this->userModel->insertUser();

            if ($result) {
                header('Location: /login');
                exit;
            } else {
                View::render('front.signup', ['error' => 'Failed to create user.']);
            }
        } else {
            View::render('front.404');
        }
    }
}
