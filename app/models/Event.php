<?php
namespace App\models;

use App\config\Database;
use App\Models\BaseModel;
use PDO;

class Event {
    protected $connection;
    private $crud;
    private $table = 'events';
    private $id;

    public function __construct() {
        $this->connection = Database::connect();
        $this->crud  = new BaseModel($this->connection);
    }

    public function getId(){
        return $this->id;
    }
    public function setId($id){
        $this->id = $id;
    }

    public function getAllEvents() {
        return $this->crud->readRecords($this->table);
    }

    public function getEventById() {
        return $this->crud->getRecord($this->table,$this->id);
    }
    public function getEvents(){
        $query = "select events.id, titre as title, events.couverture, status, users.name as organizer_name ,categories.name as category_name, date_event as date, localisation as location
        FROM events 
        LEFT JOIN categories ON events.id_categorie = categories.id 
        left join users on events.id_user = users.id";
        $stmt = $this->connection->query($query);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    

}
