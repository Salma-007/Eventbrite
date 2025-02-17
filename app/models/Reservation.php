<?php
namespace App\models;

use App\config\Database;

class Reservation {
    private $id;
    private $id_user;
    private $id_event;
    private $status;
    private static $table = 'reservations';


    public function __construct($id_user, $id_event, $status) {
        $this->id_user = $id_user;
        $this->id_event = $id_event;
        $this->status = $status;
    }

    public static function getUserReservations($userId) {
        $db = Database::connect();
        $query = "SELECT r.*, e.titre, e.description, e.date_event, e.adresse, e.couverture, e.event_type, e.prix
                  FROM " . self::$table . " r
                  JOIN events e ON r.id_event = e.id
                  WHERE r.id_user = :userId";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
