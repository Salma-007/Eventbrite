<?php

namespace App\controllers\front;

use App\core\Controller;
use App\core\View;
use App\core\Session;
use App\core\Auth;

class accueilController  extends Controller{
    
    protected $session;
    protected $auth;

    public function __construct(){
         parent::__construct();
        $this->session = new Session();
        $this->auth = new Auth();
    }

    public function pageAccueil() {
        if ($this->session->isLoggedIn()) {
            $userRole = $this->session->get('user_role');
            if ($this->auth->hasRole('admin')) {
                View::render('back.dashboard');
            } elseif ($this->auth->hasRole('organisateur')) {
                View::render('front.event');
            } elseif ($this->auth->hasRole('participant')) {
                View::render('front.home');
            } else {
                View::render('front.accueil');
            }
        } else {
            View::render('front.login');
        }
    }   
 }

