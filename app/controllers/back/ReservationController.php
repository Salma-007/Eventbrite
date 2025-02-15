<?php
namespace App\controllers\back;

use App\config\Database;
use App\core\View;
use App\core\Session;
use App\core\AuthMiddleware;

class ReservationController {
    public function __construct() {
        $this->session = new Session();
        AuthMiddleware::handle(3); // Vérification des droits d'accès
    }

    public function reserveEvent() {
        $db = Database::connect();
        $event_id = $_POST['event_id'];
        $quantity = $_POST['quantity'];
        $type = $_POST['type']; // 'payant' ou 'free'
        $user_id = $this->session->get('user_id');

        // Vérification des places disponibles
        $query = $db->prepare("SELECT nombre_place, prix FROM events WHERE id = ?");
        $query->execute([$event_id]);
        $event = $query->fetch();

        if ($event && $event['nombre_place'] >= $quantity) {
            if ($type === 'free') {
                // Réservation gratuite
                $insert = $db->prepare("INSERT INTO reservations (id_user, id_event, quantity, status) VALUES (?, ?, ?, 'reserved')");
                $insert->execute([$user_id, $event_id, $quantity]);

                // Mise à jour des places disponibles
                $update = $db->prepare("UPDATE events SET nombre_place = nombre_place - ? WHERE id = ?");
                $update->execute([$quantity, $event_id]);

                echo json_encode(['success' => true, 'message' => 'Réservation gratuite effectuée.']);
            } elseif ($type === 'payant') {
                // Créer une réservation payante et une commande
                $insertReservation = $db->prepare("INSERT INTO reservations (id_user, id_event, quantity, status) VALUES (?, ?, ?, 'reserved')");
                $insertReservation->execute([$user_id, $event_id, $quantity]);
                $reservationId = $db->lastInsertId();

                // Créer une commande
                $insertOrder = $db->prepare("INSERT INTO orders (id_reservation, quantity, total_price) VALUES (?, ?, ?)");
                $totalPrice = $event['prix'] * $quantity;
                $insertOrder->execute([$reservationId, $quantity, $totalPrice]);

                // Rediriger vers la page de paiement
                header("Location: /payment/payment?order_id={$insertOrder->lastInsertId()}&quantity={$quantity}");
                exit;
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Pas assez de places disponibles.']);
        }
    }

    public function success() {
        View::render('front.reservation-success');
    }

    public function failed($message = null) {
        View::render('front.reservation-failed', ['message' => $message]);
    }
}
