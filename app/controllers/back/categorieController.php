<?php
namespace App\controllers\back;
use App\models\Categorie;
use App\core\View;

class categorieController{
    private $categorie;

    public function __construct(){
        $this->categorie = new Categorie();
    }
    public function index() {
        $getAllCategories = $this->categorie->getAllCategories();
        View::render('back.categories', ['categories' => $getAllCategories]);
    }
    public function addCategory() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $categoryName = $_POST['categoryName']; 
            $existingCategory = $this->categorie->getCategoryByName($categoryName);
            
            if ($existingCategory) {
                echo json_encode(['status' => false, 'message' => 'The category already exists.']);
            } else {
                $this->categorie->setNom($categoryName);
                $this->categorie->insertCategorie();
                echo json_encode(['status' => true, 'message' => 'Category added successfully.']);
            }
        }
        exit; 
    }
    public function getCategories() {
        header('Content-Type: application/json'); 
        $categories = $this->categorie->getAllCategories();
        echo json_encode(['categories' => $categories]);
        exit;
    }
    
    // delete category
    public function deleteCategorie() {
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
            $id = $_GET['id']; 
            $this->categorie->setId($id);
            if ($this->categorie->deleteCategorie()) {
                echo json_encode(['status' => true]);
            } else {
                echo json_encode(['status' => false, 'message' => 'Error deleting category.']);
            }
        } else {
            echo json_encode(['status' => false, 'message' => 'Missing ID or incorrect request method.']);
        }
    }
    
    // Update category
    public function updateCategorie() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['categoryName']) && isset($_POST['categoryId'])) {
                $categoryName = $_POST['categoryName'];
                $categoryId = $_POST['categoryId'];  // Récupérer l'ID de la catégorie
    
                // Vérification si la catégorie existe déjà
                $existingCategory = $this->categorie->getCategoryByName($categoryName);
                if ($existingCategory && $existingCategory['id'] != $categoryId) {  // S'assurer que ce n'est pas la même catégorie
                    echo json_encode(['status' => false, 'message' => 'La catégorie existe déjà.']);
                } else {
                    // Mettre à jour la catégorie
                    $this->categorie->setId($categoryId);
                    $this->categorie->setNom($categoryName);
                    if ($this->categorie->updateCategorie()) {
                        echo json_encode(['status' => true, 'message' => 'La catégorie a été mise à jour avec succès.']);
                    } else {
                        echo json_encode(['status' => false, 'message' => 'Erreur lors de la mise à jour de la catégorie.']);
                    }
                }
            } else {
                echo json_encode(['status' => false, 'message' => 'Données invalides.']);
            }
        }
        exit;
    }
    
}