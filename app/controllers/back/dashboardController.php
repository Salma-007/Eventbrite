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
        View::render('back.users', ['users' => $getUsers]);
    }
    // ban user
    public function banUser(){
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $this->user->setId($id);
            $this->user->banUser();
            return header('Location: /admin/users');    
        }
    }
    // activate user
    public function activateUser(){
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $this->user->setId($id);
            $this->user->activateUser();
            return header('Location: /admin/users');    
        }
    }
    // delete user
    public function deleteUser(){
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $this->user->setId($id);
            $this->user->deleteUser();
            return header('Location: /admin/users');    
        }
    }

}