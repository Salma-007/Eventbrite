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
            $errorMessage = "The category '$categoryName' already exists.";
            View::render('back.categories', ['categories' => $this->categorie->getAllCategories(), 'errorMessage' => $errorMessage]);
        } else {
            $this->categorie->setNom($categoryName);
            $this->categorie->insertCategorie();
            View::render('back.categories', ['categories' => $this->categorie->getAllCategories()]);
        }
    }
}