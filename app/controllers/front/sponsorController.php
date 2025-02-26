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


    // delete sponsor
    public function sponsorDelete(){
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $this->sponsor->setId($id);
            if ($this->sponsor->deleteSponsor()) {
                return header('Location: /event');
            } else {
                echo "Erreur lors de la suppression de sponsor.";
            }
        } else {
            echo "ID manquant.";
        }
    }

    // get data for update
    public function sponsorUpdateForm() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            echo "ID is missing.";
            return;
        }
        $this->sponsor->setId($id);
        $sponsorById = $this->sponsor->getSponsorById();
    
        if ($sponsorById) {
            View::render('front.editSponsor', ['sponsorById' => $sponsorById]);
        } else {
            echo "Sponsor not found.";
        }
    }


    public function updateSponsor()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $sponsorId = $_POST['id'];
            $sponsorName = $_POST['name'];
            $this->sponsor->setId($sponsorId);

            if (empty($sponsorId) || empty($sponsorName)) {
                echo "ID ou Nom du sponsor invalide.";
                return;
            }

            $sponsor = $this->sponsor->getSponsorById();
            if (!$sponsor) {
                echo "Sponsor introuvable.";
                return;
            }
            $newLogo = $sponsor['logo'];             

            if (!empty($_FILES['logo']) && $_FILES['logo']['error'] === 0) {
                $uploadDirectory = __DIR__ . '/../../../public/sponsors/';
                if (!is_dir($uploadDirectory)) {
                    mkdir($uploadDirectory, 0777, true);
                }

                $uploadFile = $uploadDirectory . basename($_FILES['logo']['name']);
                $fileType = mime_content_type($_FILES['logo']['tmp_name']);
                $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];

                if (in_array($fileType, $allowedTypes)) {
                    if (move_uploaded_file($_FILES['logo']['tmp_name'], $uploadFile)) {
                        $newLogo = $_FILES['logo']['name'];
                    } else {
                        echo "Erreur lors du téléchargement du fichier.";
                        return;
                    }
                } else {
                    echo "Type de fichier non valide. Veuillez télécharger une image (jpeg, png, gif).";
                    return;
                }
            }
        }
            
        $this->sponsor->setNom($sponsorName);
        $this->sponsor->setLogo($newLogo);

        if ($this->sponsor->updateSponsor()) {
            header('Location: /event');
            exit();
        } else {
            echo "Erreur lors de la mise à jour du sponsor.";
        }
        }
    
    






}
