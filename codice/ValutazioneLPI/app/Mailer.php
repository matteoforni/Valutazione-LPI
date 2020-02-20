<?php

namespace App;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class Mailer{

    /**
     * Funzione che consente di inviare un email tramite la libreria phpmailer
     * @param $email string L'indirizzo a cui inviare il messaggio
     * @param $body string Il contenuto del messaggio
     * @param $subject string Il soggetto del messaggio
     * @return bool Se l'operazione ha avuto successo o meno
     */
    public function sendMail($email, $body, $subject){
        try{
            $mail = new PHPMailer();
            $mail->IsSMTP();
            $mail->SMTPDebug = 1;
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Host = "smtp.gmail.com";
            $mail->Port = 587;
            $mail->CharSet = 'UTF-8';
            $mail->IsHTML(true);
            $mail->Username = env('MAIL');
            $mail->Password = env('MAIL_PASSWORD');
            $mail->SetFrom(env('MAIL'));
            $mail->Subject = $subject;
            $mail->Body = $body;
            $mail->AddAddress($email);

            if(!$mail->Send()) {
                return false;
            } else {
                return true;
            }
        }catch (Exception $e){
            return false;
        }
    }
}
?>