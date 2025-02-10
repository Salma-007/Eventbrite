<?php

namespace App\controllers\front;

use App\core\View;
use App\models\Event;
use App\models\Sponsor;

class eventController {
    private $eventModel;

    public function __construct(){
        $this->eventModel = new Event();
    }

    public function home() {
        View::render('front.home');
    }

    public function readAll() {
        $sponsorModel = new Sponsor();
        $events = $this->eventModel->getAllEvents();
        $villes = $this->eventModel->getAllVilles();
        $sponsors = $sponsorModel->getAllSponsors();
    
        View::render('front.event', ['events' => $events, 'villes' => $villes, 'sponsors'=>$sponsors ]);
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
            $this->eventModel->setTitle($_POST['titre']);
            $this->eventModel->setType($_POST['type']);
            $this->eventModel->setEventType($_POST['event_type']);
            $this->eventModel->setCategoryId(null);
            $this->eventModel->setPrix($_POST['prix']);
            $this->eventModel->setLien($_POST['lien']);
            $this->eventModel->setLocation($_POST['localisation']);
            $this->eventModel->setNombrePlace($_POST['nombre_place']);
            $this->eventModel->setIdVille($_POST['ville_id']);
            $this->eventModel->setDateEvent($_POST['date_event']);
            $this->eventModel->setDateFin($_POST['date_fin']);
            $this->eventModel->setUserId(null);
    
            if ($_FILES['couverture']['error'] === 0) {
                $uploadDirectory = __DIR__ . '/../../../public/images/';
                if (!is_dir($uploadDirectory)) {
                    mkdir($uploadDirectory, 0777, true);
                }
    
                $uploadFile = $uploadDirectory . basename($_FILES['couverture']['name']);
                $fileType = mime_content_type($_FILES['couverture']['tmp_name']);
                $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
    
                if (in_array($fileType, $allowedTypes)) {
                    if (move_uploaded_file($_FILES['couverture']['tmp_name'], $uploadFile)) {
                        $this->eventModel->setCouverture($_FILES['couverture']['name']);
                    } else {
                        echo "Error moving the uploaded file.";
                        return; 
                    }
                } else {
                    echo "Invalid file type. Please upload an image (jpeg, png, or gif).";
                    return; 
                }
            }
            $event_id = $this->eventModel->createEvent();
    
            if ($event_id) {
                header("Location: /event");
                exit(); 
            } else {
                echo "Une erreur est survenue lors de la création de l'événement.";
            }
        }
    }
    
    
    
}
