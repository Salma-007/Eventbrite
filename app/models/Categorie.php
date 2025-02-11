<?php
namespace App\models;
use App\config\Database;
use App\models\BaseModel;
use PDO;

class Categorie{
    private $id;
    private $nom_categorie;
    private $table = 'categories';
    private $crud;
    private $conn;

    public function __construct($nom = null, $id = -1 ){
        $this->conn = Database::connect();
        $this->id = $id;
        $this->nom_categorie = $nom;
        $this->crud  = new BaseModel($this->conn);
    }

    public function setNom($nom){
        $this->nom_categorie = $nom;
    }
    public function getNom(){
        return $this->nom_categorie;
    }
    public function setId($id){
        $this->id = $id;
    }
    public function getId(){
        return $this->id;
    }
    // fonction d'ajout
    public function insertCategorie(){
        $data = [
            'name' => $this->nom_categorie
        ];
        return $this->crud->insertRecord($this->table, $data);
    }

    public function getCategoryByName($category){
        $this->crud->getRecordbyName($this->table, $category);
    }
    // fonction suppression
    public function deleteCategorie(){
        return $this->crud->deleteRecord($this->table, $this->id);
    }
    // fonction update
    public function updateCategorie(){
        $query = "SELECT * FROM " . $this->table . " WHERE name = :nom_categorie";
        $stmt = $this->conn->prepare($query); 
        $stmt->bindParam(':nom_categorie', $this->nom_categorie, PDO::PARAM_STR);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $_SESSION['error_categorie_update'] = "categorie already exists!";
            header('Location: /categories');  
            exit(); 
        }
        else{
            $data = [
                'name'=>$this->nom_categorie
            ];
            return $this->crud->updateRecord($this->table, $data, $this->id);
        }
    }
    // recuperation de toutes Categories
    public function getAllCategories(){
        return $this->crud->readRecords($this->table);
    }
    //get a record by id
    public function getCategoriebyId(){
        return $this->crud->getRecord($this->table,$this->id);
    }
    // count des categories
    public function getCountCategories(){
        return $this->crud->getTableCount($this->table);
    }

    

}