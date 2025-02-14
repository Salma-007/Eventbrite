<?php
namespace App\controllers\front;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class contactController {
    public function send() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
            $message = htmlspecialchars($_POST["message"]);
        
            if (!empty($email) && !empty($message) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $to = "salmaelallali3@gmail.com"; 
                $subject = "Nouveau message de contact";
                $headers = "From: " . $email . "\r\n" .
                           "Reply-To: " . $email . "\r\n" .
                           "MIME-Version: 1.0\r\n" .
                           "Content-Type: text/plain; charset=UTF-8\r\n";
        
                $body = "Email : $email\n\nMessage :\n$message";

                if (mail($to, $subject, $body, $headers)) {
                    echo "Votre message a été envoyé avec succès.";
                } else {
                    echo "Erreur lors de l'envoi du message.";
                }
            } else {
                echo "Veuillez entrer un email valide et un message.";
            }
        }
    }
}
