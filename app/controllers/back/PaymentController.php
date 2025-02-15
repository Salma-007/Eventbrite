<?php
namespace App\controllers\back;

use App\core\Database;
use App\core\View;
use App\core\Session;

class PaymentController {
    public function payment() {
        $db = Database::connect();

        $paypal_email = 'sb-7x7d436888426@personal.example.com';
        $order_id = $_GET['order_id'];
        $quantity = isset($_GET['quantity']) ? (int)$_GET['quantity'] : 1;
        $item_name = 'Réservation d\'événement';
        $item_amount = 50.00 * $quantity;
        $item_currency = 'USD';

        $paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';

        $query = http_build_query([
            'cmd' => '_xclick',
            'business' => $paypal_email,
            'item_name' => $item_name,
            'amount' => $item_amount,
            'currency_code' => $item_currency,
            'return' => 'http://' . $_SERVER['HTTP_HOST'] . '/payment/success?order_id=' . $order_id . '&quantity=' . $quantity,
            'cancel_return' => 'http://' . $_SERVER['HTTP_HOST'] . '/payment/cancel',
            'notify_url' => 'http://' . $_SERVER['HTTP_HOST'] . '/payment/ipn',
        ]);

        header('Location: ' . $paypal_url . '?' . $query);
        exit;
    }

    public function success() {
        // Afficher la page de confirmation du paiement réussi
        View::render('front.merci');
    }

    public function cancel() {
        // Afficher la page d'annulation du paiement
        View::render('front.annule');
    }

    public function ipn() {
        $db = Database::connect();
        $paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';

        $raw_post_data = file_get_contents('php://input');
        $raw_post_array = explode('&', $raw_post_data);
        $myPost = [];
        foreach ($raw_post_array as $keyval) {
            $keyval = explode('=', $keyval);
            if (count($keyval) == 2) {
                $myPost[$keyval[0]] = urldecode($keyval[1]);
            }
        }

        error_log("Données reçues de PayPal: " . print_r($myPost, true));

        $req = 'cmd=_notify-validate';
        foreach ($myPost as $key => $value) {
            $value = urlencode(stripslashes($value));
            $req .= "&$key=$value";
        }

        $ch = curl_init($paypal_url);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Connection: Close']);

        if (!($res = curl_exec($ch))) {
            error_log("Erreur de connexion à PayPal: " . curl_error($ch));
            curl_close($ch);
            exit;
        }
        curl_close($ch);

        if (strcmp($res, "VERIFIED") == 0) {
            $order_id = $_POST['custom'];
            $quantity = $_POST['quantity'];

            try {
                // Insertion du paiement dans la table "paiements"
                $payment_query = $db->prepare("INSERT INTO paiements (mode, id_order, amount, payment_status) VALUES (:mode, :order_id, :amount, 'completed')");
                $payment_query->execute([
                    ':mode' => 'PayPal',
                    ':order_id' => $order_id,
                    ':amount' => $_POST['mc_gross']
                ]);

                // Mettre à jour les places disponibles
                $update_event_query = $db->prepare("UPDATE events SET nombre_place = nombre_place - :quantity WHERE id = (SELECT id_event FROM reservations WHERE id = (SELECT id_reservation FROM orders WHERE id = :order_id))");
                $update_event_query->execute([
                    ':quantity' => $quantity,
                    ':order_id' => $order_id
                ]);

                // Changer le statut de la réservation à "payé"
                $update_reservation_query = $db->prepare("UPDATE reservations SET status = 'paid' WHERE id = (SELECT id_reservation FROM orders WHERE id = :order_id)");
                $update_reservation_query->execute([':order_id' => $order_id]);

            } catch (\PDOException $e) {
                error_log("Erreur lors de l'insertion ou de la mise à jour dans la base de données: " . $e->getMessage());
                exit;
            }
        }
    }
}
