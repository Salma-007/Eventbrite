<?php

namespace App\controllers\front;

use App\core\View;

class eventController{

    public function home() {
        View::render('front.home');
    }

    public function event() {
        View::render('front.event');
    }
}