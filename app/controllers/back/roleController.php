<?php
namespace App\controllers\back;

use App\core\Controller;
use App\core\View;
use App\core\Session;

class roleController extends Controller {
    protected $session;

    public function __construct() {
        parent::__construct();
        $this->session = new Session();
    }

    public function choisirRole() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $role = $_POST['role'];

            // voir  si users est connecte
            if (!$this->session->isLogging()) {
                header("Location: /login");
                exit;
            }

            switch ($role) {
                case 'organisateur':
                    header("Location: /event");
                    break;
                case 'participant':
                    header("Location: /");
                    break;
                default:
                    header("Location: /accueil");
                    break;
            }
            exit;
        } else {
            View::render('front.accueil');
        }
    }
}
