<?php

namespace App\controllers\back;
use App\core\View;
use App\models\User;

class dashboardController{
    private $user;
    public function __construct() {
        $this->user = new User();
    }

    public function index() {
        View::render('back.dashboard');
    }
    public function usersAdmin(){
        $getUsers = $this->user->getUsers();
        View::render('back.users');
    }

}