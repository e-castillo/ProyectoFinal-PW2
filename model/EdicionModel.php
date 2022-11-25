<?php

class EdicionModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function getEdiciones($idUsuario)
    {
        $sql = 'SELECT e.id_edicion, e.fecha, p.nombre, p.imagen
        FROM edicion e JOIN producto p ON e.id_producto=p.id_producto
        
        ORDER BY p.nombre';

        $sql = 'SELECT e.id_edicion, e.fecha, p.nombre, p.imagen, c.usuario as comprado
        FROM edicion e JOIN producto p ON e.id_producto=p.id_producto
        LEFT JOIN (select * from compra as c where usuario = ' . $idUsuario . ') AS c on e.id_edicion = c.edicion 
        ORDER BY p.nombre';

        return $this->database->query($sql);
    }

    public function getAllEdiciones()
    {
        $sql = "SELECT * FROM edicion";
        return $this->database->query($sql);
    }

    public function getEdicionById($id)
    {
        $sql = "SELECT * FROM edicion WHERE id_edicion=" . $id;
        return $this->database->query($sql);
    }

    public function setEdicion($idProducto, $fecha, $evento, $precio)
    {
        $sql = "INSERT INTO edicion
                (`fecha`, `id_producto`, `evento`, `precio`) 
                VALUES ('$fecha', '$idProducto', '$evento','$precio')";
        $this->database->execute($sql);
    }
}