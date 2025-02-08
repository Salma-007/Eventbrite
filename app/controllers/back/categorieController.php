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
}