<?php

namespace App\controllers\front;
use App\models\Event;
use App\models\Sponsor;
use App\core\View;
use App\core\Validator;
use Exception;

class eventController{
    private $event;
    private $id;
    public function __construct(){
        $this->event = new Event();
    }

    public function home() {
        $sponsorModel = new Sponsor();
        $events = $this->event->getAllEvents();
        $villes = $this->event->getAllVilles();
        $sponsors = $sponsorModel->getAllSponsors();
        $categories = $this->event->getAllCategories();
        $regions = $this->event->getAllRegions();
    
        View::render('front.home', ['events' => $events, 'villes' => $villes, 'sponsors'=>$sponsors, 'categories' => $categories, 'regions'=>$regions]);
    }

    public function details() {
        if (isset($_GET['id'])) {
            $this->event->setId($_GET['id']);
            $eventById = $this->event->getEventById();
            $sponsorModel = new Sponsor();
            $villes = $this->event->getAllVilles();
            $sponsors = $sponsorModel->getAllSponsors();
            $categories = $this->event->getAllCategories();
            $regions = $this->event->getAllRegions();
    
            if ($eventById) {
                View::render('front.singlePage', ['eventById' => $eventById, 'villes' => $villes, 'sponsors'=>$sponsors, 'categories' => $categories, 'regions'=>$regions]);
            } else {
                echo "Événement introuvable.";
            }
        } else {
            echo "ID d'événement manquant.";
        }
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
        $regions = $this->event->getAllRegions();
    
        View::render('front.event', ['events' => $events, 'villes' => $villes, 'sponsors'=>$sponsors, 'categories' => $categories, 'regions'=>$regions]);
    }

    public function VilleByRegion(){
        $regionId = isset($_GET['id']) ? $_GET['id'] : null;
        if (!$regionId) {
            echo json_encode([]);
            echo "empty";
            return;
        }
        $this->event->setIdRegion($regionId);
        $villes = $this->event->getAllVilles();
        echo json_encode($villes);
    }

    public function create() {
        $sponsorModel = new Sponsor();
        $events = $this->event->getAllEvents();
        $villes = $this->event->getAllVilles();
        $sponsors = $sponsorModel->getAllSponsors();
        $categories = $this->event->getAllCategories();
        $regions = $this->event->getAllRegions();
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $validator = new Validator();
                $data = [
                    'titre' => $_POST['titre'] ?? null,
                    'type' => $_POST['type'] ?? null,
                    'event_type' => $_POST['event_type'] ?? null,
                    'id_categorie' => $_POST['id_categorie'] ?? null,
                    'prix' => $_POST['prix'] ?? null,
                    'lien' => $_POST['lien'] ?? null,
                    'adresse' => $_POST['adresse'] ?? null,
                    'description' => $_POST['description'] ?? null,
                    'nombre_place' => $_POST['nombre_place'] ?? null,
                    'ville_id' => $_POST['ville_id'] ?? null,
                    'date_event' => $_POST['date_event'] ?? null,
                    'date_fin' => $_POST['date_fin'] ?? null,
                ];
    
                if (!$validator->validate($data)) {
                    $errors = $validator->getErrors();
    
                    echo json_encode(['errors' => $errors]);
                    exit(); 
                }

                $titre = htmlspecialchars(trim($data['titre']));
                $type = htmlspecialchars(trim($data['type']));
                $eventType = htmlspecialchars(trim($data['event_type']));
                $categoryId = intval($data['id_categorie']);
                $prix = !empty($data['prix']) ? floatval($data['prix']) : 0.0;
                $lien = !empty($data['lien']) ? filter_var($data['lien'], FILTER_SANITIZE_URL) : null;
                $adresse = !empty($data['adresse']) ? htmlspecialchars(trim($data['adresse'])) : null;
                $description = htmlspecialchars(trim($data['description']));
                $nombrePlace = intval($data['nombre_place']);
                $idVille = intval($data['ville_id']);
                $dateEvent = $data['date_event'];
                $dateFin = $data['date_fin'];
                $userId = null;

                $this->event->setTitle($titre);
                $this->event->setType($type);
                $this->event->setEventType($eventType);
                $this->event->setCategoryId($categoryId);
                $this->event->setPrix($prix);
                $this->event->setLien($lien);
                $this->event->setAdresse($adresse);
                $this->event->setNombrePlace($nombrePlace);
                $this->event->setIdVille($idVille);
                $this->event->setDateEvent($dateEvent);
                $this->event->setDateFin($dateFin);
                $this->event->setUserId($userId);
                $this->event->setDescription($description);
    
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
                    'adresse' => $adresse,
                    'nombre_place' => $nombrePlace,
                    'id_ville' => $idVille,
                    'date_event' => $dateEvent,
                    'date_fin' => $dateFin,
                    'id_user' => $userId,
                    'description' => $description,
                    'sponsors' => $_POST['sponsors'] ?? []
                ];
    
                $event_id = $this->event->createEvent($eventData);
    
                if (!$event_id) {
                    throw new Exception("Échec de la création de l'événement.");
                }
    
                echo json_encode(['success' => true]);
                exit();
    
            } catch (Exception $e) {
                echo json_encode(['errors' => ['general' => $e->getMessage()]]);
                exit();
            }
        }

        View::render('front.event', [
            'events' => $events,
            'villes' => $villes,
            'sponsors' => $sponsors,
            'categories' => $categories,
            'regions' => $regions,
            'errors' => null
        ]);
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

    public function show() {
        if (isset($_GET['id'])) {
            $this->event->setId($_GET['id']);
            $eventById = $this->event->getEventById();
            $sponsorModel = new Sponsor();
            $villes = $this->event->getAllVilles();
            $sponsors = $sponsorModel->getAllSponsors();
            $categories = $this->event->getAllCategories();
            $regions = $this->event->getAllRegions();
    
            if ($eventById) {
                View::render('front.editEvent', ['eventById' => $eventById, 'villes' => $villes, 'sponsors'=>$sponsors, 'categories' => $categories, 'regions'=>$regions]);
            } else {
                echo "Événement introuvable.";
            }
        } else {
            echo "ID d'événement manquant.";
        }
    }


    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $id = isset($_POST['id']) ? intval($_POST['id']) : null;
                if (!$id) {
                    throw new Exception("ID de l'événement manquant.");
                }
                $this->event->setId($id);
                $event = $this->event->getEventById();
                if (!$event) {
                    throw new Exception("Événement non trouvé.");
                }
    
                $titre = isset($_POST['titre']) ? htmlspecialchars(trim($_POST['titre'])) : null;
                $type = isset($_POST['type']) ? htmlspecialchars(trim($_POST['type'])) : null;
                $eventType = isset($_POST['event_type']) ? htmlspecialchars(trim($_POST['event_type'])) : null;
                $categoryId = isset($_POST['id_categorie']) ? intval($_POST['id_categorie']) : null;
                $prix = isset($_POST['prix']) ? floatval($_POST['prix']) : 0.0;
                $lien = isset($_POST['lien']) ? filter_var($_POST['lien'], FILTER_SANITIZE_URL) : null;
                $adresse = isset($_POST['adresse']) ? htmlspecialchars(trim($_POST['adresse'])) : null;
                $description = isset($_POST['description']) ? htmlspecialchars(trim($_POST['description'])) : null;
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
                $this->event->setAdresse($adresse);
                $this->event->setNombrePlace($nombrePlace);
                $this->event->setIdVille($idVille);
                $this->event->setDateEvent($dateEvent);
                $this->event->setDateFin($dateFin);
                $this->event->setUserId($userId);
                $this->event->setDescription($description);
    

                if (!empty($_FILES['couverture']) && $_FILES['couverture']['error'] === 0) {
                    $fileName = $this->uploadFile($_FILES['couverture']);
                    if ($fileName) {
                        $this->event->setCouverture($fileName);
                    } else {
                        throw new Exception("Erreur lors de l'upload du fichier.");
                    }
                } else {
                    $this->event->setCouverture($event['couverture']);
                }
    
                $eventData = [
                    'id' => $id,
                    'titre' => $titre,
                    'type' => $type,
                    'event_type' => $eventType,
                    'id_categorie' => $categoryId,
                    'couverture' => $this->event->getCouverture(),
                    'prix' => $prix,
                    'lien' => $lien,
                    'adresse' => $adresse,
                    'nombre_place' => $nombrePlace,
                    'id_ville' => $idVille,
                    'date_event' => $dateEvent,
                    'date_fin' => $dateFin,
                    'id_user' => $userId,
                    'description' => $description,
                    'sponsors' => isset($_POST['sponsors']) ? $_POST['sponsors'] : []
                ];
    
                $updated = $this->event->updateEvent($eventData);
    
                if (!$updated) {
                    throw new Exception("Échec de la mise à jour de l'événement.");
                }
    
                header("Location: /event");
                exit();
            } catch (Exception $e) {
                echo "Erreur : " . $e->getMessage();
            }
        }
    }
    
    
    
    
}
