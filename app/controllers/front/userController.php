<?php
namespace App\controllers\front;

use App\core\Controller;
use App\models\User;
use App\core\View;
use App\core\Security;

class UserController extends Controller {
    protected $userModel;

    public function __construct() {
        parent::__construct();
        $this->userModel = new User();
    }

   




    public function homePage() {
        $isLoggedIn = $this->session->isLoggedIn();
        View::render('home', ['isLoggedIn' => $isLoggedIn]);   
     }
    

}
