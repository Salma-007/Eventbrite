<?php

namespace App\controllers\front;

use App\core\View;
use App\models\Event;

class eventController {

    public function home() {
        View::render('front.home');
    }

    public function event() {
        View::render('front.event');
    }

    public function readAll() {
        $eventModel = new Event();
        $events = $eventModel->getAllEvents();
        View::render('front.event', ['events' => $events]);
    }
}
