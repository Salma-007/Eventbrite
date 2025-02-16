<?php
namespace App\controllers\back;

use App\models\Payment;
use App\models\Reservation;
use App\models\Order;
use App\config\Database;
use App\core\View;
use App\core\Session;
use PDO;

class PaymentController {
    private $paypal_email = 'sb-7x7d436888426@personal.example.com'; // Email PayPal Sandbox
    private $paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr'; // URL PayPal Sandbox
    private $session;
    private $db;

    public function __construct() {
        $this->session = new Session();
        $this->db = Database::connect();
    }

    /**
     * Redirige l'utilisateur vers PayPal pour effectuer le paiement.
     */
    public function payment() {
        $order_id = $_GET['order_id'];
        $stmt =$this->db->prepare("SELECT * FROM orders WHERE id = :order_id");
        $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
        $stmt->execute();
        $order = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$order) die("Commande introuvable.");

        // Construire l'URL de redirection PayPal
        $query = http_build_query([
            'cmd' => '_xclick',
            'business' => $this->paypal_email,
            'item_name' => 'Réservation d\'événement',
            'amount' => $order['amount'],
            'currency_code' => 'USD',
            'return' => 'http://' . $_SERVER['HTTP_HOST'] . '/payment/success?order_id=' . $order_id,
            'cancel_return' => 'http://' . $_SERVER['HTTP_HOST'] . '/payment/cancel',
            'notify_url' => 'http://' . $_SERVER['HTTP_HOST'] . '/payment/ipn',
            'custom' => $order['id_reservation'], // Passer l'ID de la réservation
        ]);

        header('Location: ' . $this->paypal_url . '?' . $query);
        exit;
    }

    /**
     * Traite les notifications IPN de PayPal.
     */
    public function ipn() {
        // Vérifiez que la requête provient de PayPal
        if (!isset($_POST['payment_status']) || !isset($_POST['txn_id'])) {
            error_log('Requête invalide: données manquantes.');
            echo json_encode(['success' => false, 'message' => 'Requête invalide: données manquantes.']);
            return;
        }

        $payment_status = $_POST['payment_status'];
        $transaction_id = $_POST['txn_id']; // ID de transaction PayPal
        $reservation_id = $_POST['custom']; // ID de la réservation passée via le champ 'custom'

        if ($payment_status !== 'Completed') {
            error_log('Paiement non complet.');
            echo json_encode(['success' => false, 'message' => 'Paiement non complet.']);
            return;
        }

        $this->db = Database::connect();

        try {
            $this->db->beginTransaction();

            // Vérifiez que la réservation existe
            $query = $this->db->prepare("SELECT id FROM reservations WHERE id = ?");
            $query->execute([$reservation_id]);
            $reservation = $query->fetch();

            if (!$reservation) {
                throw new \Exception('Réservation introuvable.');
            }

            // Mettre à jour le statut de la réservation
            $updateReservation = $this->db->prepare("UPDATE reservations SET status = 'paid' WHERE id = ?");
            $updateReservation->execute([$reservation_id]);

            // Enregistrer le paiement
            $payment = new Payment('PayPal', $reservation_id , 'completed');
            $payment->create();

            $this->db->commit();
            error_log('Paiement réussi et réservation enregistrée.');
            echo json_encode(['success' => true, 'message' => 'Paiement réussi et réservation enregistrée.']);
        } catch (\Exception $e) {
            $this->db->rollBack();
            error_log('Erreur lors de l\'enregistrement de la réservation: ' . $e->getMessage());
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    /**
     * Affiche la page de succès après un paiement réussi.
     */
    public function success() {
        View::render('front.reservation-success');
    }

    /**
     * Affiche la page d'annulation après un paiement annulé.
     */
    public function cancel() {
        View::render('front.reservation-cancel');
    }
}