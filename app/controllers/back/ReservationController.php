<?php
namespace App\controllers\back;

use App\models\Reservation;
use App\models\Order;
use App\config\Database;
use App\core\Session;
use App\core\AuthMiddleware;
use App\core\View;

class ReservationController {
    public function __construct() {
        $this->session = new Session();
        AuthMiddleware::handle(3); // Vérification des droits d'accès
    }

    public function reserveEvent() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $event_id = $_POST['event_id'];
            $type = $_POST['type']; // 'payant' ou 'free'
            $user_id = $this->session->get('user_id');

            $db = Database::connect();

            try {
                $db->beginTransaction();
                $query = $db->prepare("SELECT nombre_place, prix FROM events WHERE id = ?");
                $query->execute([$event_id]);
                $event = $query->fetch();

                if (!$event || $event['nombre_place'] < 1) {
                    throw new \Exception('Pas assez de places disponibles.');
                }

                if ($type === 'free') {
                    $reservation = new Reservation($user_id, $event_id, 'reserved');
                    $reservation->create();
                    $update = $db->prepare("UPDATE events SET nombre_place = nombre_place - 1 WHERE id = ?");
                    $update->execute([$event_id]);
                    $db->commit();
                    header("Location: /reservation/success");
                    exit;
                } elseif ($type === 'payant') {
                    $reservation = new Reservation($user_id, $event_id, 'reserved');
                    $reservation->create();
                    $update = $db->prepare("UPDATE events SET nombre_place = nombre_place - 1 WHERE id = ?");
                    $update->execute([$event_id]);
                    $order = new Order($reservation->getId(), $event['prix']);
                    $order->create();
                    $db->commit();
                    header("Location: /payment/payment?order_id={$order->getId()}");
                    exit;
                

                } else {
                    $db->commit();
                    header("Location: /reservation/success");
                    exit;
                }
            } catch (\Exception $e) {
                $db->rollBack();
                echo json_encode(['success' => false, 'message' => $e->getMessage()]);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
        }
    }

    public function success() {
        View::render('front.reservation-success');
    }

    public function failed($message = null) {
        View::render('front.reservation-failed', ['message' => $message]);
    }
}
