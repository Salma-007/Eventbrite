<?php
namespace App\controllers\front;

use App\models\Sponsor;
use App\core\View;

class SponsorController {
    private $sponsor;

    public function __construct() {
        $this->sponsor = new Sponsor();
    }

    // Ajouter un sponsor
    public function addSponsor()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $sponsorName = $_POST['name'];

            if ($_FILES['logo']['error'] === 0) {
                $uploadDirectory = __DIR__ . '/../../../public/sponsors/';
                if (!is_dir($uploadDirectory)) {
                    mkdir($uploadDirectory, 0777, true);
                }
    
                $uploadFile = $uploadDirectory . basename($_FILES['logo']['name']);
                $fileType = mime_content_type($_FILES['logo']['tmp_name']);
                $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
    
                if (in_array($fileType, $allowedTypes)) {
                    if (move_uploaded_file($_FILES['logo']['tmp_name'], $uploadFile)) {
                        $this->sponsor->setLogo($_FILES['logo']['name']);
                    } else {
                        echo "Error moving the uploaded file.";
                        return; 
                    }
                } else {
                    echo "Invalid file type. Please upload an image (jpeg, png, or gif).";
                    return; 
                }
            }

            $this->sponsor->setNom($sponsorName);
    
            if ($this->sponsor->insertSponsor()) {
                header('Location: /event');
                exit();
            } else {
                echo "Erreur lors de l'ajout du sponsor.";
            }
        }
    }

    




}
