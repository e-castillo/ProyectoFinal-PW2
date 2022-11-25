<?php

class SessionUser{

    public function __construct(){

    }

    public function setCurrentUser($user){
        $_SESSION['usuario'] = $user;
    }

    public function getCurrentUser(){
        return $_SESSION['usuario'] ?? 0;
    }

    public function getRol(){
        return $_SESSION['usuario']['rol'] ?? 0;
    }

    public function getIdUsuario(){
        $sesion = $this->getCurrentUser();
        if($sesion != 0){
            return $sesion['id_usuario'];
        }else{
            return $sesion;
        }
    }

    public function obtenerRolUsuario(){
        if($this->getRol() == 1){
            return 'admin';
        }else if($this->getRol() == 2) {
            return 'lector';
        }else if($this->getRol() == 3) {
            return 'editor';
        }else{
            return '';
        }
    }

    public function closeSession(){
        session_unset();
        session_destroy();
    }
}
