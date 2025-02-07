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
    

}
