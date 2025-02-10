<?php

namespace App\controllers\front;
use App\models\Event;
use App\core\View;

class eventController{
    private $event;
    private $id;
    public function __construct(){
        $this->event = new Event();
    }

    public function home() {
        View::render('front.home');
    }

    public function event() {
        View::render('front.event');
    }
    public function getEvents(){
        $getAllEvents = $this->event->getEvents();
        // var_dump($getAllEvents);
        View::render('back.eventsmanage', ['events' => $getAllEvents]);
    }

    public function readAll() {
        $eventModel = new Event();
        $events = $eventModel->getAllEvents();
        $villes = $eventModel->getAllVilles();
    
        View::render('front.event', ['events' => $events, 'villes' => $villes]);
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
            $eventModel->setIdVille($_POST['ville_id']);
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
                $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
    
                if (in_array($fileType, $allowedTypes)) {
                    if (move_uploaded_file($_FILES['couverture']['tmp_name'], $uploadFile)) {
                        $eventModel->setCouverture($_FILES['couverture']['name']);
                    } else {
                        echo "Error moving the uploaded file.";
                        return; 
                    }
                } else {
                    echo "Invalid file type. Please upload an image (jpeg, png, or gif).";
                    return; 
                }
            }
            $event_id = $eventModel->createEvent();
    
            if ($event_id) {
                header("Location: /event");
                exit(); 
            } else {
                echo "Une erreur est survenue lors de la création de l'événement.";
            }
        }
    }   
    public function refuseEvent(){
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $this->event->setId($id);
            if ($this->event->refuseEvent()) {
                return header('Location: /admin/events');
            } else {
                echo "Erreur !";
            }
        } else {
            echo "ID manquant.";
        }
    } 
    public function acceptEvent(){
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $this->event->setId($id);
            if ($this->event->acceptEvent()) {
                return header('Location: /admin/events');
            } else {
                echo "Erreur !";
            }
        } else {
            echo "ID manquant.";
        }
    } 
    
}
