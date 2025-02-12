<?php
namespace App\controllers\back;

use App\core\Controller;
use App\core\View;
use App\core\Session;
use App\Models\User;


class roleController extends Controller {
    protected $session;
    protected $userModel;


    public function __construct() {
        parent::__construct();
        $this->session = new Session();
        $this->userModel = new User();

    }

    public function choisirRole() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $role = $_POST['role'];


            // voir  si users est connecte
            if (!$this->session->isLogging()) {
                header("Location: /login");
                exit;
            }

            $userId = $this->session->get('user_id');
            $roleId = $this->userModel->getRoleIdByName($role);

            if ($roleId) {
                $this->userModel->assignRoleToUser($userId, $roleId);
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
            } else {
                View::render('front.accueil', ['error' => 'Role not found.']);
            }
            exit;
        } else {
            View::render('front.accueil');
        }
    }
}
