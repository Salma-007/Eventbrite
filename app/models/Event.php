<?php
namespace App\Models;

use App\Config\Database;
use App\Models\BaseModel;
use PDO;

class Event {
    protected $connection;
    private $id;
    private $title;
    private $type;
    private $event_type;
    private $category_id;
    private $couverture;
    private $prix;
    private $lien;
    private $location;
    private $nombre_place;
    private $id_ville;
    private $date_event;
    private $date_fin;
    private $user_id;
    private $table = 'events';
    private $crud;

    public function __construct() {
        $this->connection = Database::connect();
        $this->crud = new BaseModel();
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function getCategoryId() {
        return $this->category_id;
    }

    public function setCategoryId($category_id) {
        $this->category_id = $category_id;
    }

    public function getUserId() {
        return $this->user_id;
    }

    public function setUserId($user_id) {
        $this->user_id = $user_id;
    }

    public function getIdVille() {
        return $this->id_ville;
    }

    public function setIdVille($id_ville) {
        $this->id_ville = $id_ville;
    }

    public function getTitle() {
        return $this->title;
    }
    
    public function setTitle($title) {
        $this->title = $title;
    }
    
    public function getType() {
        return $this->type;
    }
    
    public function setType($type) {
        $this->type = $type;
    }
    
    public function getEventType() {
        return $this->event_type;
    }
    
    public function setEventType($event_type) {
        $this->event_type = $event_type;
    }
    
    public function getCouverture() {
        return $this->couverture;
    }
    
    public function setCouverture($couverture) {
        $this->couverture = $couverture;
    }
    
    public function getPrix() {
        return $this->prix;
    }
    
    public function setPrix($prix) {
        $this->prix = $prix;
    }
    
    public function getLien() {
        return $this->lien;
    }
    
    public function setLien($lien) {
        $this->lien = $lien;
    }
    
    public function getLocation() {
        return $this->location;
    }
    
    public function setLocation($location) {
        $this->location = $location;
    }
    
    public function getNombrePlace() {
        return $this->nombre_place;
    }
    
    public function setNombrePlace($nombre_place) {
        $this->nombre_place = $nombre_place;
    }
    
    public function getDateEvent() {
        return $this->date_event;
    }
    
    public function setDateEvent($date_event) {
        $this->date_event = $date_event;
    }
    
    public function getDateFin() {
        return $this->date_fin;
    }
    
    public function setDateFin($date_fin) {
        $this->date_fin = $date_fin;
    }
    public function getEvents(){
        $query = "select events.id, titre as title, events.couverture, status, users.name as organizer_name ,categories.name as category_name, date_event as date, localisation as location
        FROM events 
        LEFT JOIN categories ON events.id_categorie = categories.id 
        left join users on events.id_user = users.id where status = 'pending'";
        $stmt = $this->connection->query($query);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    

    public function getAllEvents() {
        try {
            $query = "SELECT * FROM events";
            $stmt = $this->connection->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            die("Erreur lors de la récupération des événements : " . $e->getMessage());
        }
    }

    public function createEvent() {
        try {
            $query = "INSERT INTO events (titre, type, event_type, id_categorie, couverture, prix, lien, localisation, nombre_place, id_ville, date_event, date_fin, id_user) 
                      VALUES (:titre, :type, :event_type, :id_categorie, :couverture, :prix, :lien, :localisation, :nombre_place, :id_ville, :date_event, :date_fin, :id_user)";
    
            $stmt = $this->connection->prepare($query);
    
            $stmt->bindParam(':titre', $this->title);
            $stmt->bindParam(':type', $this->type);
            $stmt->bindParam(':event_type', $this->event_type);
            $stmt->bindParam(':id_categorie', $this->category_id);
            $stmt->bindParam(':couverture', $this->couverture);
            $stmt->bindParam(':prix', $this->prix);
            $stmt->bindParam(':lien', $this->lien);
            $stmt->bindParam(':localisation', $this->location);
            $stmt->bindParam(':nombre_place', $this->nombre_place);
            $stmt->bindParam(':id_ville', $this->id_ville);
            $stmt->bindParam(':date_event', $this->date_event);
            $stmt->bindParam(':date_fin', $this->date_fin);
            $stmt->bindParam(':id_user', $this->user_id);
    
            if ($stmt->execute()) {
                return $this->connection->lastInsertId(); 
            } else {
                return false;
            }
        } catch (\PDOException $e) {
            die("Erreur lors de la création de l'événement : " . $e->getMessage());
        }
    }

    public function getAllVilles() {
        $stmt = $this->connection->prepare("SELECT * FROM villes");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); 
    }
    public function refuseEvent(){
        $data = [
            'status' => 'refuse'
        ];
        return $this->crud->updateRecord($this->table, $data, $this->id);
    }
    public function acceptEvent(){
        $data = [
            'status' => 'accepted'
        ];
        return $this->crud->updateRecord($this->table, $data, $this->id);
    }

    public function pendingCount(){
        $data = [
            'status' => 'pending'
        ];
        return $this->crud->readWithCondition($this->table, $data);
    }
    
}
