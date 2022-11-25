<?php
    class RegistroController{
        private $registroModel;
        private $view;
        private $session;

        public function __construct($registroModel,$view, $session){
            $this->registroModel = $registroModel;
            $this->view = $view;
            $this->session = $session;
        }

        public function list($data = []){
            $this->view->render('registroView.mustache',$data);
        }

        public function registrarUsuario(){
            if(ValidatorHelper::validarSeteadoYNoVacio($_POST["nombre"]) &&
                ValidatorHelper::validarSeteadoYNoVacio($_POST["usuario"]) &&
                ValidatorHelper::validarSeteadoYNoVacio($_POST["clave"]) &&
                ValidatorHelper::validarSeteadoYNoVacio($_POST["email"])) {

            $name = $_POST["nombre"];
            $user = $_POST["usuario"];
            $pass = $_POST["clave"];
            $email = $_POST["email"];
            $rol = $_POST["rol"];

            $status = $this->registroModel->registrar($name,$user,$pass,$email,$rol);

                if($status == "existente"){
                    $this->duplicate();
                }else{
                    Redirect::doIt("/infonet/verificacion");
                }

            }else{
                $this->incorrectFormat();
            }

        }


        public function duplicate(){
            $data['title'] = "Usuario o email ya registrados";
            $this->list($data);
        }

        public function incorrectFormat(){
            $data['validador'] = true;
            $this->view->render('registroView.mustache',$data);
        }



    }
