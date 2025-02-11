<?php

namespace App\controllers\front;

use App\core\View;

class accueilController{
    
    public function __construct(){
        
    }

    public function pageAccueil() {
        View::render('front.accueil');
    }

}