<?php
namespace App\models;

use App\config\Database;
use App\models\BaseModel;
use PDO;
use Exception;

class Sponsor {
    private $id;
    private $nom;
    private $logo;
    private $table = 'sponsors';
    private $crud;
    private $conn;

    public function __construct($nom = null, $logo = null, $id = -1) {
        $this->conn = Database::connect();
        $this->id = $id;
        $this->nom = $nom;
        $this->logo = $logo;
        $this->crud  = new BaseModel($this->conn);
    }

    public function setNom($nom) {
        $this->nom = $nom;
    }
    public function getNom() {
        return $this->nom;
    }

    public function setLogo($logo) {
        $this->logo = $logo;
    }
    public function getLogo() {
        return $this->logo;
    }

    public function setId($id) {
        $this->id = $id;
    }
    public function getId() {
        return $this->id;
    }

    public function getAllSponsors() {
        return $this->crud->readRecords($this->table);
    }

    public function getSponsorById() {
        return $this->crud->getRecord($this->table, $this->id);
    }
    

    public function insertSponsor() {
        $data = [
            'name' => $this->nom,
            'logo' => $this->logo
        ];
        return $this->crud->insertRecord($this->table, $data);
    }

    public function deleteSponsor() {
        return $this->crud->deleteRecord($this->table, $this->id);
    }

    public function updateSponsor() {
        try {
            $query = "SELECT * FROM " . $this->table . " WHERE name = :nom AND id != :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':nom', $this->nom, PDO::PARAM_STR);
            $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $_SESSION['error_Sponsor_update'] = "Ce sponsor existe déjà !";
                return false; 
            }

            $data = [
                'name' => $this->nom,
                'logo' => $this->logo
            ];
            return $this->crud->updateRecord($this->table, $data, $this->id);

        } catch (Exception $e) {
            echo "Erreur lors de la mise à jour du sponsor : " . $e->getMessage();
            return false;
        }
    }

    
}
