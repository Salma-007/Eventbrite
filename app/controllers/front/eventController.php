<?php

namespace App\controllers\front;

use App\core\View;
use App\models\Event;

class eventController {

    public function home() {
        View::render('front.home');
    }

    public function event() {
        View::render('front.event');
    }

    public function readAll() {
        $eventModel = new Event();
        $events = $eventModel->getAllEvents();
        View::render('front.event', ['events' => $events]);
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $eventModel = new Event();

            $eventModel->setTitle($_POST['titre']);
            $eventModel->setType($_POST['type']);
            $eventModel->setEventType($_POST['event_type']);
            $eventModel->setCategoryId(null);
            $eventModel->setPrix($_POST['prix']);
            $eventModel->setLien($_POST['lien']);
            $eventModel->setLocation($_POST['localisation']);
            $eventModel->setNombrePlace($_POST['nombre_place']);
            $eventModel->setIdVille(null);
            $eventModel->setDateEvent($_POST['date_event']);
            $eventModel->setDateFin($_POST['date_fin']);
            $eventModel->setUserId(null);

            if ($_FILES['couverture']['error'] === 0) {
                $uploadDirectory = __DIR__ . '/../../../public/images/';
                if (!is_dir($uploadDirectory)) {
                    mkdir($uploadDirectory, 0777, true); 
                }
                
                $uploadFile = $uploadDirectory . basename($_FILES['couverture']['name']);
                $fileType = mime_content_type($_FILES['couverture']['tmp_name']);
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            
                if (in_array($fileType, $allowedTypes)) {
                    if (move_uploaded_file($_FILES['couverture']['tmp_name'], $uploadFile)) {
                        $eventModel->setCouverture($_FILES['couverture']['name']);
                        $event_id = $eventModel->createEvent();
                    } else {
                        echo "Error moving the uploaded file.";
                    }
                } else {
                    echo "Invalid file type. Please upload an image (jpeg, png, or gif).";
                }
            }     
            $event_id = $eventModel->createEvent();
    
            if ($event_id) {
                header("Location: /event");
            } else {
                echo "Une erreur est survenue lors de la création de l'événement.";
            }
        }
    }
    
}
