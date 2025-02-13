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
            extract($_POST);
            var_dump($categoryName);
            $this->categorie->setId($categoryId);
            $this->categorie->setNom($categoryName);
            if ($this->categorie->updateCategorie()) {
                return header('Location: /categories');
            } else {
                echo "Erreur lors de la mise à jour de la catégorie.";
            }
        }
    }
}