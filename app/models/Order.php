<?php
namespace App\models;

use App\config\Database;

class Order {
    private $id;
    private $id_reservation;

    public function __construct($id_reservation) {
        $this->id_reservation = $id_reservation;
 
    }

    

    public function create() {
        $db = Database::connect();
        $query = $db->prepare("INSERT INTO orders (id_reservation) VALUES (?)");
        $query->execute([$this->id_reservation]);
        $this->id = $db->lastInsertId();
    }

    public function getId() {
        return $this->id;
    }

    public function getIdReservation() {
        return $this->id_reservation;
    }
}