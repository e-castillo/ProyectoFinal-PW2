<?php

class PagoModel{

    private $database;

    public function __construct($database){
        $this->database = $database;
    }

    public function getCompra($usuario, $edicion){
        $sql = 'SELECT c.id_compra, c.usuario, c.edicion FROM compra c 
                JOIN edicion e ON c.edicion=e.id_edicion 
                ORDER BY c.edicion';

        return $this->database->query($sql);
    }

    public function setCompra($usuario, $edicion){
        $sql = "INSERT INTO compra (`usuario`,`edicion`)
                values ('$usuario', '$edicion')";

        $this->database->execute($sql);
    }
}