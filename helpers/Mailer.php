<?php

require_once('dependencies/PHPMailer/src/Exception.php');
require_once('dependencies/PHPMailer/src/PHPMailer.php');
require_once('dependencies/PHPMailer/src/SMTP.php');

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class Mailer extends PHPMailer
{
    public function __construct($exceptions = null)
    {
        parent::__construct($exceptions);
        $this->config();
    }

    private function config()
    {
        $this->isSMTP();
        $this->Host       = 'smtp.gmail.com';
        $this->SMTPAuth   = true;
        $this->Username   = 'somosinfonet22@gmail.com';
        $this->Password   = 'sarifruapycoyfws';
        $this->SMTPSecure = 'tls';
        $this->Port       = 587;
        $this->setFrom('somosinfonet22@gmail.com', 'Infonet');
    }

    public function sendEmail($email, $user)
    {
        $to  = $email;
        $subject = 'Confirmacion de registro en Infonet';
        $message = "Bienvenido/a, ".$user."!!!!
                        Su cuenta ha sido creada. Por favor, ingrese al siguiente link para activarla:
                        
                        http://localhost/infonet/login/activarCuenta?user=$user                        
                    ";
        try {
            $this->addAddress($to);
            $this->Subject = $subject;
            $this->Body    = $message;
            $this->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

}