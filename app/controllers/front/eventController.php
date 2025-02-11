<?php

namespace App\controllers\front;
use App\models\Event;
use App\models\Sponsor;
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
        $getCount = $this->event->pendingCount();
        $getAllEvents = $this->event->getEvents();
        // var_dump($getAllEvents);
        View::render('back.eventsmanage', ['events' => $getAllEvents]);
    }

    public function readAll() {
        $sponsorModel = new Sponsor();
        $events = $this->event->getAllEvents();
        $villes = $this->event->getAllVilles();
        $sponsors = $sponsorModel->getAllSponsors();
        $categories = $this->event->getAllCategories();
    
        View::render('front.event', ['events' => $events, 'villes' => $villes, 'sponsors'=>$sponsors, 'categories' => $categories]);
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
            $this->event->setTitle($_POST['titre']);
            $this->event->setType($_POST['type']);
            $this->event->setEventType($_POST['event_type']);
            $this->event->setCategoryId(null);
            $this->event->setPrix($_POST['prix']);
            $this->event->setLien($_POST['lien']);
            $this->event->setLocation($_POST['localisation']);
            $this->event->setNombrePlace($_POST['nombre_place']);
            $this->event->setIdVille($_POST['ville_id']);
            $this->event->setDateEvent($_POST['date_event']);
            $this->event->setDateFin($_POST['date_fin']);
            $this->event->setUserId(null);
    
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
                        $this->event->setCouverture($_FILES['couverture']['name']);
                    } else {
                        echo "Error moving the uploaded file.";
                        return; 
                    }
                } else {
                    echo "Invalid file type. Please upload an image (jpeg, png, or gif).";
                    return; 
                }
            }
            $event_id = $this->event->createEvent();
    
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
