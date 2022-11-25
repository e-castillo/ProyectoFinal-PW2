<?php

class ArticuloModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function getArticulos()
    {
        $sql = "SELECT * FROM articulo";
        return $this->database->query($sql);
    }

    public function getArticuloPorId($id)
    {
        $sql = "SELECT * FROM articulo WHERE id_articulo='$id'
                AND id_estado=2";
        return $this->database->query($sql);
    }

    public function getEstadosDeArticulos()
    {
        $sql = "SELECT * FROM estado";
        return $this->database->query($sql);
    }

    public function getArticulosPorSeccion($idSeccion)
    {
        $sql = "SELECT * FROM articulo a 
                JOIN seccion s ON s.id_seccion=a.id_seccion
                WHERE a.id_seccion ='$idSeccion' AND a.id_estado=2";
        return $this->database->query($sql);
    }

    public function setArticulo($seccion, $edicion, $titulo, $subtitulo, $imagen, $texto, $autor)
    {
        $sql = "INSERT INTO articulo 
                (`titulo`, `subtitulo`, `texto`, `autor`, `imagen`, `id_edicion`, `id_seccion`) 
                VALUES ('$titulo', '$subtitulo', '$texto', '$autor', '$imagen', '$edicion', '$seccion');";
        $this->database->execute($sql);
    }

    public function updateEstadoArticulo($idEstado, $idArticulo)
    {
        $sql = "UPDATE `articulo` SET `id_estado` = '$idEstado' WHERE (`id_articulo` = '$idArticulo')";
        $this->database->execute($sql);
    }

    function isPublicado(){
        $sql = "SELECT id_estado, descripcion 
                FROM estado
                WHERE id_estado=2;";
        return $this->database->query($sql);
    }




    /*ajax*/
    public function getArticulosPorEdicionAJax($idEdicion)
    {
        $sql = "SELECT a.id_articulo, a.titulo, a.subtitulo, a.texto,
                a.autor, a.imagen, a.latitud, a.longitud, 
                a.id_edicion, e.fecha, e.evento AS evento, a.id_seccion, s.nombre AS nombreSeccion,
                a.id_estado, es.descripcion AS estado
                FROM articulo a JOIN seccion s ON s.id_seccion=a.id_seccion
                JOIN edicion e ON e.id_edicion=a.id_edicion
                JOIN estado es ON es.id_estado=a.id_estado
                WHERE a.id_edicion=" . $idEdicion . "
                ORDER BY a.id_articulo";
        $format = $this->database->query($sql);
        return print json_encode($format, JSON_UNESCAPED_UNICODE);
    }

    public function deleteArticulo($id)
    {
        $sql = "DELETE FROM articulo WHERE articulo.id_articulo=" . $id;
        $this->database->execute($sql);
    }

    public function updateArticulo($id, $titulo, $subtitulo, $imagen, $texto, $autor)
    {
        $sql = "UPDATE articulo a 
                SET a.titulo='$titulo', a.texto = '$texto', a.subtitulo='$subtitulo',
                a.autor = '$autor',
                a.imagen='$imagen'
                WHERE a.id_articulo='$id'";
        $this->database->execute($sql);
    }

    public function getArticuloComprado($id, $idUsuario){
        $sql = "select c.id_compra from compra c JOIN articulo a ON c.edicion = a.id_edicion
                WHERE c.usuario ='$idUsuario' AND
                a.id_articulo ='$id'";
        return $this->database->query($sql);
    }

    public function getSeccionComprada($id, $idUsuario){
        $sql = "select c.id_compra from compra c JOIN seccion s ON c.edicion = s.id_edicion
                WHERE c.usuario ='$idUsuario' AND
                s.id_seccion ='$id'";
        return $this->database->query($sql);
    }
}