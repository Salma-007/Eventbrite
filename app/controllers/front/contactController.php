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
                $mail = new PHPMailer(true);

                try {
                    // Server settings
                    $mail->isSMTP();
                    $mail->Host       = 'smtp.gmail.com'; // Gmail's SMTP server
                    $mail->SMTPAuth   = true;            // Enable SMTP authentication
                    $mail->Username   = 'salmaelallali3@gmail.com'; // Your Gmail address
                    $mail->Password   = 'rzep sibw kwgz hivl';  // Your Gmail password or app password
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption
                    $mail->Port       = 587;             // TCP port to connect to

                    // Recipients
                    $mail->setFrom($email);              // Sender's email
                    $mail->addAddress($email); // Recipient's email

                    // Content
                    $mail->isHTML(false);                // Set email format to plain text
                    $mail->Subject = 'Nouveau message de contact';
                    $mail->Body    = "Email : $email\n\nMessage :\n$message";
                        
                    $mail->send();
                    echo "Votre message a été envoyé avec succès.";
                } catch (Exception $e) {
                    echo "Erreur lors de l'envoi du message. Mailer Error: {$mail->ErrorInfo}";
                }
            } else {
                echo "Veuillez entrer un email valide et un message.";
            }
        }
    }
}