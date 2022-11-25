<?php

class VerificacionController{

    private $view;

    public function __construct($view){
        $this->view = $view;

    }

    public function list(){
        $this->view->render('verificacionView.mustache');
    }

}