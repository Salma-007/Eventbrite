<?php
namespace App\models;

use App\config\Database;
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

    public function __construct() {
        $this->connection = Database::connect();
    }

    public function getId(){
        return $this->id;
    }
    public function setId($id){
        $this->id = $id;
    }

    public function getCategoryId(){
        return $this->category_id;
    }
    public function setCategoryId($category_id){
        $this->category_id = $category_id;
    }

    public function getUserId(){
        return $this->user_id;
    }
    public function setUserId($user_id){
        $this->user_id = $user_id;
    }

    public function getIdVille(){
        return $this->id_ville;
    }
    public function setIdVille($id_ville){
        $this->id_ville = $id_ville;
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
}
