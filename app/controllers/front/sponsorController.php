<?php
namespace App\controllers\back;

use App\models\Sponsor;
use App\core\View;

class SponsorController {
    private $sponsor;

    public function __construct() {
        $this->sponsor = new Sponsor();
    }

    // Afficher la liste des sponsors
    public function index() {
        $getAllSponsors = $this->sponsor->getAllSponsors();
        View::render('front.event', ['sponsors' => $getAllSponsors]);
    }

    // Ajouter un sponsor
    public function addSponsor() {
        $sponsorName = $_POST['name']; 
        $logo = $_FILES['logo'] ?? null;

        if ($sponsorName && $logo) {
            $existingSponsor = $this->sponsor->getSponsorByName($sponsorName);
            if ($existingSponsor) {
                $errorMessage = "Le sponsor existe déjà.";
                View::render('front.event', ['sponsors' => $this->sponsor->getAllSponsors(), 'errorMessage' => $errorMessage]);
            } else {
                $uploadDir = __DIR__ . '/../../../public/images/';
                $logoPath = $uploadDir . basename($logo["name"]);

                if (move_uploaded_file($logo["tmp_name"], $logoPath)) {
                    $this->sponsor->setNom($sponsorName);
                    $this->sponsor->setLogo($logoPath);
                    $this->sponsor->insertSponsor();
                    View::render('front.event', ['sponsors' => $this->sponsor->getAllSponsors()]);
                } else {
                    $errorMessage = "Erreur lors de l'upload du logo.";
                    View::render('front.event', ['sponsors' => $this->sponsor->getAllSponsors(), 'errorMessage' => $errorMessage]);
                }
            }
        } else {
            $errorMessage = "Tous les champs sont obligatoires.";
            View::render('front.event', ['sponsors' => $this->sponsor->getAllSponsors(), 'errorMessage' => $errorMessage]);
        }
    }


}
