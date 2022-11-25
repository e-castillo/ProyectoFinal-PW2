<?php

class RegistroModel{

    private $database;
    private $mailer;

    public function __construct($database, $mailer){
        $this->database = $database;
        $this->mailer = $mailer;
    }

    public function registrar($name,$user,$pass,$email,$rol){
        if(!$this->emailExistente($email)
            && !$this->userExistente($user)){
            $passMd5 = md5($pass);
            $sql = "INSERT INTO usuario (nombre,password,usuario,email,rol) VALUES ('".$name."','".$passMd5."','".$user."','".$email."','".$rol."')";
            $this->database->execute($sql);
            $confirmation = $this->mailer->sendEmail($email,$user);
            if($confirmation){
                $status = "registrado";
                return $status;
            }else{
                $status = "noregistrado";
                return $status;
            }
        }else{
            $status = "existente";
            return $status;
        }
    }

    private function emailExistente($email){
        $sql= "SELECT 1 FROM usuario where email ='".$email."'";
        $result = $this->database->queryResult($sql);
        return (isset($result["1"]));

    }

    private function userExistente($user){
        $sql= "SELECT 1 FROM usuario where usuario ='".$user."'";
        $result = $this->database->queryResult($sql);
        return (isset($result["1"]));

    }

    private function sendConfirmationMail($email,$user){
        $to  = $email;
        $subject = 'Confirmacion de registro en Infonet';
        $message = "Bienvenido/a, ".$user."!
        
        
                        Su cuenta ha sido creada. Por favor, ingrese al siguiente link para activarla:
                        
                        http://localhost/infonet/login/activarCuenta?user=$user
                        
                    ";

        $mail = new PHPMailer(true);

        try {
            $mail->SMTPDebug = 0;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'somosinfonet22@gmail.com';                     //SMTP username
            $mail->Password   = 'sarifruapycoyfws';                               //SMTP password
            $mail->SMTPSecure = 'tls';            //Enable implicit TLS encryption
            $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
            $mail->setFrom('somosinfonet22@gmail.com', 'Infonet');
            $mail->addAddress($to);     //Add a recipient
            //$mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = $message;
            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }

    }
}