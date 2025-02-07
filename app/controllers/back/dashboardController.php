<?php

namespace App\controllers\back;
// use App\models\Dashboard;
use App\core\View;

class dashboardController{

    public function index() {
        View::render('back.dashboard');
    }
}