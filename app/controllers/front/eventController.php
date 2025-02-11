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
            try {
                $titre = isset($_POST['titre']) ? htmlspecialchars(trim($_POST['titre'])) : null;
                $type = isset($_POST['type']) ? htmlspecialchars(trim($_POST['type'])) : null;
                $eventType = isset($_POST['event_type']) ? htmlspecialchars(trim($_POST['event_type'])) : null;
                $categoryId = isset($_POST['id_categorie']) ? intval($_POST['id_categorie']) : null;
                $prix = isset($_POST['prix']) ? floatval($_POST['prix']) : 0.0;
                $lien = isset($_POST['lien']) ? filter_var($_POST['lien'], FILTER_SANITIZE_URL) : null;
                $localisation = isset($_POST['localisation']) ? htmlspecialchars(trim($_POST['localisation'])) : null;
                $nombrePlace = isset($_POST['nombre_place']) ? intval($_POST['nombre_place']) : 0;
                $idVille = isset($_POST['ville_id']) ? intval($_POST['ville_id']) : null;
                $dateEvent = isset($_POST['date_event']) ? $_POST['date_event'] : null;
                $dateFin = isset($_POST['date_fin']) ? $_POST['date_fin'] : null;
                $userId = null;
    
                $this->event->setTitle($titre);
                $this->event->setType($type);
                $this->event->setEventType($eventType);
                $this->event->setCategoryId($categoryId);
                $this->event->setPrix($prix);
                $this->event->setLien($lien);
                $this->event->setLocation($localisation);
                $this->event->setNombrePlace($nombrePlace);
                $this->event->setIdVille($idVille);
                $this->event->setDateEvent($dateEvent);
                $this->event->setDateFin($dateFin);
                $this->event->setUserId($userId);

                if (!empty($_FILES['couverture']) && $_FILES['couverture']['error'] === 0) {
                    $fileName = $this->uploadFile($_FILES['couverture']);
                    if ($fileName) {
                        $this->event->setCouverture($fileName);
                    } else {
                        throw new Exception("Erreur lors de l'upload du fichier.");
                    }
                }

                $eventData = [
                    'titre' => $titre,
                    'type' => $type,
                    'event_type' => $eventType,
                    'id_categorie' => $categoryId,
                    'couverture' => $this->event->getCouverture(),
                    'prix' => $prix,
                    'lien' => $lien,
                    'localisation' => $localisation,
                    'nombre_place' => $nombrePlace,
                    'id_ville' => $idVille,
                    'date_event' => $dateEvent,
                    'date_fin' => $dateFin,
                    'id_user' => $userId,
                    'sponsors' => isset($_POST['sponsors']) ? $_POST['sponsors'] : []
                ];
    
                $event_id = $this->event->createEvent($eventData);
    
                if (!$event_id) {
                    throw new Exception("Échec de la création de l'événement.");
                }
    
                header("Location: /event");
                exit();
            } catch (Exception $e) {
                echo "Erreur : " . $e->getMessage();
            }
        }
    }
    
    private function uploadFile($file) {
        $uploadDirectory = __DIR__ . '/../../../public/images/';
        
        if (!is_dir($uploadDirectory)) {
            mkdir($uploadDirectory, 0777, true);
        }
    
        $fileName = basename($file['name']);
        $uploadPath = $uploadDirectory . $fileName;
        $fileType = mime_content_type($file['tmp_name']);
        $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
    
        if (in_array($fileType, $allowedTypes)) {
            if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
                return $fileName; 
            }
        }
    
        return false; 
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

    public function delete() {
        if (isset($_GET['id'])) {
            $eventId = $_GET['id'];
            $this->event->setId($eventId);

            if ($this->event->deleteSponsor()) {
                header("Location: /event?success=Event supprimé avec succès");
                exit();
            } else {
                header("Location: /event?error=Erreur lors de la suppression de l'événement");
                exit();
            }
        } else {
            header("Location: /event?error=Requête invalide");
            exit();
        }
    }
    
    
}
