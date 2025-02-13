<?php

namespace App\controllers\back;
use App\core\View;
use App\models\Event;
use App\models\Categorie;
use App\models\User;

class dashboardController{
    private $user;
    private $event;
    private $categorie;

    public function __construct() {
        $this->user = new User();
        $this->event = new Event();
        $this->categorie = new Categorie();
    }

    public function index() {
        $event_stats = $this->event->countReservationsByEvent();
        $topEvents = $this->event->getTopEvents();
        $getCountCategorie = $this->categorie->getCountCategories();
        $getCountUSers = $this->user->getCountUsers();
        $CountAcceptedEvents = $this->event->CountAcceptedEvents();
        $events = [];
        $counts = [];
        $colors = [
        'rgb(78, 115, 223)',    // primary
        'rgb(28, 200, 138)',    // success
        'rgb(54, 185, 204)',    // info
        'rgb(246, 194, 62)',    // warning
        'rgb(231, 74, 59)',     // danger
        'rgb(133, 135, 150)',   // secondary
        'rgb(90, 92, 105)',     // dark
        'rgb(244, 246, 249)'    // light
        ];
        foreach ($event_stats as $stat) {
        $events[] = $stat['events_name'];
        $counts[] = $stat['total_reservation'];
        }
        View::render('back.dashboard', ['topEvent' => $topEvents,'events' => $events, 'counts' => $counts, 'colors' => $colors, 'event_stats' => $event_stats,'getCountCategorie' => $getCountCategorie,'getCountUSers' => $getCountUSers,'CountAcceptedEvents' => $CountAcceptedEvents]);
    }
    public function usersAdmin(){
        $getUsers = $this->user->getUsers();
        View::render('back.users', ['users' => $getUsers]);
    }
    // ban user
    public function banUser(){
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $this->user->setId($id);
            $this->user->banUser();
            echo json_encode(['status' => true]);
            exit;
        }
        echo json_encode(['status' => false, 'message' => 'User not found']);
    }
    
    // activate user
    public function activateUser(){
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $this->user->setId($id);
            $this->user->activateUser();
            echo json_encode(['status' => true]);
            exit; 
        }
        echo json_encode(['status' => false, 'message' => 'User not found']);
    }
    
    // delete user
    public function deleteUser(){
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $this->user->setId($id);
            $this->user->deleteUser();
            echo json_encode(['status' => true]);
            exit; 
        }
        echo json_encode(['status' => false, 'message' => 'User not found']);
    }
    

}