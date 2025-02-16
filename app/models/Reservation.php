<?php
namespace App\models;

use App\config\Database;

class Reservation {
    private $id;
    private $id_user;
    private $id_event;
    private $status;

    public function __construct($id_user, $id_event, $status) {
        $this->id_user = $id_user;
        $this->id_event = $id_event;
        $this->status = $status;
    }

    public function create() {
        $db = Database::connect();
        $query = $db->prepare("INSERT INTO reservations (id_user, id_event,  status) VALUES (?, ?, ?)");
        $query->execute([$this->id_user, $this->id_event,$this->status]);
        $this->id = $db->lastInsertId();
    }

    public function getId() {
        return $this->id;
    }

    public function getIdUser() {
        return $this->id_user;
    }

    public function getIdEvent() {
        return $this->id_event;
    }

  

    public function getStatus() {
        return $this->status;
    }
}
