<?php

namespace App\controllers\front;

use App\core\Controller;
use App\core\View;
use App\core\Session;
use App\core\AuthMiddleware;
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
        if ($this->session->isLogging()) {
            $userRole = $this->session->get('user_role');
            switch ($userRole) {
              
                case 'organisateur':
                    AuthMiddleware::handle($userRole);
                    View::render('front.event');
                    break;
                case 'participant':
                    
                    AuthMiddleware::handle($userRole);
                    View::render('front.home');
                    break;
                default:
                    View::render('front.accueil');
                    break;
            }
        } else {
            View::render('front.login');
        }
    }   
 }

