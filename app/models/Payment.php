<?php
namespace App\models;

use App\config\Database;

class Payment {
    private $id;
    private $mode;
    private $id_order;
    private $payment_status;

    public function __construct($mode, $id_order,$payment_status='completed') {
        $this->mode = $mode;
        $this->id_order = $id_order;
        $this->payment_status = $payment_status;
    }

    public function create() {
        $db = Database::connect();
        $query = $db->prepare("INSERT INTO paiements (mode, id_order, payment_status) VALUES (?, ?, ?)");
        $query->execute([$this->mode, $this->id_order, $this->payment_status]);
        $this->id = $db->lastInsertId();
    }

    public function getId() {
        return $this->id;
    }

  
}
