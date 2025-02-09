<?php

namespace App\controllers\front;
use App\models\Event;
use App\core\View;

class eventController{
    private $event;
    public function __construct(){
        $this->event =  new Event();
    }
    public function home() {
        View::render('front.home');
    }

    public function event() {
        View::render('front.event');
    }
    public function getEvents(){
        $getAllEvents = $this->event->getEvents();
        // var_dump($getAllEvents);
        View::render('back.eventsmanage', ['events' => $getAllEvents]);
    }
}