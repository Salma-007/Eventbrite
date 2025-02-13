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
    // add categorie
    public function addCategory() {
        $categoryName = $_POST['categoryName']; 
        $existingCategory = $this->categorie->getCategoryByName($categoryName);
        if ($existingCategory) {
            $errorMessage = "The category already exists.";
            return View::render('back.categories', ['categories' => $this->categorie->getAllCategories(), 'errorMessage' => $errorMessage]);
        } else {
            $this->categorie->setNom($categoryName);
            $this->categorie->insertCategorie();
            View::render('back.categories', ['categories' => $this->categorie->getAllCategories()]);
        }
    }
    
    // delete category
    public function deleteCategorie(){
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $this->categorie->setId($id);
            if ($this->categorie->deleteCategorie()) {
                return header('Location: /categories');
            } else {
                echo "Erreur lors de la suppression de la catégorie.";
            }
        } else {
            echo "ID manquant.";
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