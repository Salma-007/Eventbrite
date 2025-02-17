<?php
namespace App\controllers\back;

use App\core\Controller;
use App\core\View;
use App\core\Session;
use App\core\Security;

use App\models\User;

class ProfileController extends Controller
{
    protected $session;
    protected $userModel;

    public function __construct()
    {
        parent::__construct();
        $this->session = new Session();
        $this->userModel = new User();
    
    }

    public function voirProfile()
    {
        if (!$this->session->isLogging()) {
            header("Location: /login");
            exit;
        }

        $userId = $this->session->get('user_id');
        $this->userModel->setId($userId);
        $user = $this->userModel->getUserById();

        View::render('back.profile', ['user' => $user]);
    }
    public function updateProfile()
    {
        if (!$this->session->isLogging()) {
            header("Location: /login");
            exit;
        }

        $userId = $this->session->get('user_id');
        $this->userModel->setId($userId);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            // Handle file upload
            if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == UPLOAD_ERR_OK) {
                $uploadDir = __DIR__ . '/../../../public/assets/img/uploadsProfile/';
                $uploadFile = $uploadDir . basename($_FILES['profile_image']['name']);

                if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $uploadFile)) {
                    $profileImage = '/../../public/assets/img/uploadsProfile/' . basename($_FILES['profile_image']['name']);
                } else {
                    
                    $profileImage = $this->userModel->getProfileImage();
                }
            } 
            $hashedPassword = Security::hashPassword($password);

            $this->userModel->setName($name);
            $this->userModel->setEmail($email);
            $this->userModel->setPassword($hashedPassword);
            $this->userModel->setProfileImage($profileImage);

            $this->userModel->updateUser();

            header("Location: /profile");
            exit;
        }
    }

}
