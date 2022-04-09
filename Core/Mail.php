<?php

namespace App\Core;


use App\Libraries\Session;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

require '../vendor/phpmailer/phpmailer/src/Exception.php';
require '../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../vendor/phpmailer/phpmailer/src/SMTP.php';

class Mail {

    private $session;

    public function __construct()
    {
        $this->session = new Session();
    }


    public function send($data) {
        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;
            // If uncomment, not work in local//Activer la sortie de débogage
            //$mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = MAIL_HOST;                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = MAIL_USER;                     //SMTP username
            $mail->Password   = MAIL_PASS;                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            $mail->CharSet = "utf-8";

            //Recipients
            $mail->setFrom('audrey.openclassroom@gmail.com', 'OcBlog');
            $mail->addAddress('fcz.audrey@gmail.com', 'Audrey Fcz');     //Add a recipient

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Oc Blog Mailer';
            $mail->Body    = $data;

            $mail->send();
            header('Location: ../main');
            $this->session->set('message','Message has been sent'); ;
        } catch (Exception $e) {
            $this->session->set('error','Message hasn\'t been sent');
            //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }

    }
}
