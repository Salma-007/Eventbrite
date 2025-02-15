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
                    $mail->isSMTP();
                    $mail->Host       = 'smtp.gmail.com'; 
                    $mail->SMTPAuth   = true;            
                    $mail->Username   = 'salmaelallali3@gmail.com'; 
                    $mail->Password   = 'rzep sibw kwgz hivl'; 
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
                    $mail->Port       = 587;             


                    $mail->setFrom($email);            
                    $mail->addAddress($email); 

                    // Content
                    $mail->isHTML(false);               
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