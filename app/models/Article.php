<?php
namespace App\models;

use App\config\Database;
use PDO;

class Article {
    protected $connection;

    public function __construct() {
        $this->connection = Database::connect();
    }

    public function getArticles() {
        $query = "SELECT * FROM article";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getArticleById($id) {
        $query = "SELECT * FROM article WHERE id = :id";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    

}
