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


    public function logout() {
        $this->session->destroy(); 
        header('Location: /login');
        exit;
    }
    public function checkLogin() {
        return $this->session->isLoggedIn();
    }
}
