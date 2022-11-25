<?php

class LoginController{
    private $view;
    private $loginModel;
    private $session;

    public function __construct($loginModel, $view, $session){
        $this->loginModel = $loginModel;
        $this->view = $view;
        $this->session = $session;
    }

    public function list($data = []){
        $this->view->render('loginView.mustache',$data);
    }

    public function validarSesion(){
        if(ValidatorHelper::validarSeteadoYNoVacio($_POST["usuario"]) &&
            ValidatorHelper::validarSeteadoYNoVacio($_POST["password"])) {
            $usuario = $_POST["usuario"];
            $password = $_POST["password"];
            $obj = $this->loginModel->iniciarSesion($usuario, $password);
            if (!empty($obj)) {
                if($obj["activo"] == 1){
                    $this->session->setCurrentUser($obj);
                    Redirect::doIt("/infonet/producto");
                }else{
                    $this->notActivo();
                }

            } else {
                $this->notRegistered();
            }
        }else{
            $this->incorrectFormat();
        }
    }

    public function activarCuenta(){
        if(isset($_GET['user'])){
            $user = $_GET['user'];
            $this->loginModel->activarCuenta($user);
            $data['activado'] = true;
            $this->list($data);
        }

    }

    private function incorrectFormat(){
        $data['validador'] = true;
        $this->view->render('loginView.mustache',$data);
    }

    private function notRegistered(){
        $data['confirmed'] = true;
        $this->list($data);
    }

    private function notActivo(){
        $data['desactivado'] = true;
        $this->list($data);
    }

    public function logout(){
        $this->session->closeSession();
        Redirect::doIt("/infonet/producto");
    }

}