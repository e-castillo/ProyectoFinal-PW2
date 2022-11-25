<?php

class HistorialModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function getEdiciones($idUsuario, $desde, $hasta)
    {
        $sql = "";
        if ($desde != "" && $hasta != "") {
            $sql = ' SELECT e.id_edicion, e.fecha, p.nombre, p.imagen,  e.evento
               FROM edicion e JOIN producto p ON e.id_producto=p.id_producto
               JOIN compra c on e.id_edicion = c.edicion
               where usuario = '. $idUsuario .' and e.fecha >= "' . $desde . '" and e.fecha <= "' . $hasta . '"
               ORDER BY fecha';


        } else if ($desde != "" && $hasta == "") {
            $sql = ' SELECT e.id_edicion, e.fecha, p.nombre, p.imagen,  e.evento
               FROM edicion e JOIN producto p ON e.id_producto=p.id_producto
               JOIN compra c on e.id_edicion = c.edicion
               where usuario = '. $idUsuario .' and e.fecha >= "' . $desde . '"
               ORDER BY fecha';

        } else if ($desde == "" && $hasta != "") {
            $sql = ' SELECT e.id_edicion, e.fecha, p.nombre, p.imagen,  e.evento
               FROM edicion e JOIN producto p ON e.id_producto=p.id_producto
               JOIN compra c on e.id_edicion = c.edicion
               where usuario = '. $idUsuario .' and e.fecha <= "' . $hasta . '"
               ORDER BY fecha';
        } else {
            $sql = ' SELECT e.id_edicion, e.fecha, p.nombre, p.imagen,  e.evento
               FROM edicion e JOIN producto p ON e.id_producto=p.id_producto
               JOIN compra c on e.id_edicion = c.edicion
               where usuario = '. $idUsuario .'
               ORDER BY fecha';
        }
        return $this->database->query($sql);


    }
}

/*
 SELECT
    *
FROM
    (SELECT
        e.id_edicion, e.fecha, p.nombre, p.imagen, e.evento
    FROM
        suscripcion s
    JOIN producto p ON s.id_producto = p.id_producto
    JOIN edicion e ON p.id_producto = e.id_producto
    JOIN usuario u ON s.id_usuario = u.id_usuario
    WHERE
        u.id_usuario = 2 UNION SELECT
        e.id_edicion, e.fecha, p.nombre, p.imagen, e.evento
    FROM
        edicion e
    JOIN producto p ON e.id_producto = p.id_producto
    JOIN compra c ON e.id_edicion = c.edicion
    WHERE
        usuario = 2
    ORDER BY nombre) AS misEdiciones
ORDER BY fecha;

 */