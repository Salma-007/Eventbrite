<?php
namespace App\controllers\front;

use App\core\View;
use App\core\Session;
use App\models\Reservation;

class UserReservationController {
    private $session;

    public function __construct() {
        $this->session = new Session();
    }

    public function index() {
        // Vérifiez si l'utilisateur est connecté
        if (!$this->session->isLogging()) {
            header("Location: /login");
            exit;
        }

        // Récupérez l'ID de l'utilisateur connecté
        $userId = $this->session->get('user_id');

        // Récupérez les réservations de l'utilisateur
        $reservations = Reservation::getUserReservations($userId);

        // Affichez la vue avec les réservations de l'utilisateur
        View::render('front.mesReservations',['reservations' => $reservations]);
    }
}
