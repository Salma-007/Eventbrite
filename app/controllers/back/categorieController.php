<?php
namespace App\controllers\back;
use App\core\View;

class categorieController{
    public function index() {
        View::render('back.categories');
    }
}