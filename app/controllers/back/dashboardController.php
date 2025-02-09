<?php

namespace App\controllers\back;
use App\core\View;

class dashboardController{

    public function index() {
        View::render('back.dashboard');
    }
}