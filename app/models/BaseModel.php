<?php
namespace App\Models;
use App\config\Database;
use PDO;

class BaseModel{
    protected $conn;
    public function __construct(){
        $this->conn = Database::getInstance();
    }

    //methode d'affichage de tous les records
    public function readRecords($table) {
        $query = "SELECT * FROM $table;";
        $stmt = $this->conn->query($query);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
     // methode d'insertion 
     public function insertRecord($table, $data) {
        
        $columns = implode(',', array_keys($data));
        $placeholders = implode(',', array_fill(0, count($data), '?'));

        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";

        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            die("Error in prepared statement: " . print_r($conn->errorInfo(), true));
        }
        $result = $stmt->execute(array_values($data));
        return $this->conn->lastInsertId();
    }
    //methode d'afficher une record
    public function getRecord($table, $id){
        $query = "SELECT * FROM $table WHERE id = :id";
        $stmt = $this->conn->prepare($query);
            if ($stmt->execute(['id' => $id])) {
            $resultat = $stmt->fetch(PDO::FETCH_ASSOC);
            return $resultat;
        } else {
            return null;
        }
    }
}