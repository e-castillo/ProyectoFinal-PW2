<?php

class ProductoModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function getProductos()
    {
        $sql = 'SELECT p.id_producto, p.nombre, p.imagen, t.descripcion, p.precio as precio
                FROM producto p JOIN tipo t ON p.tipo=t.id_tipo_producto';
        return $this->database->query($sql);
    }

    public function getProducto($id)
    {
        $sql = "SELECT p.id_producto, p.nombre, p.imagen, t.descripcion, p.precio as precio
                FROM producto p JOIN tipo t ON p.tipo=t.id_tipo_producto
                WHERE p.id_producto=" . $id;
        return $this->database->query($sql);
    }

    public function getEdicionesDeCadaProducto($id, $idUsuario)
    {

        $sql = 'SELECT e.id_edicion as id_edicion, e.fecha, e.precio as precio, p.nombre as producto, p.imagen, c.usuario as comprado
                FROM edicion e JOIN producto p ON e.id_producto=p.id_producto
                LEFT JOIN (select * from compra as c where usuario = ' . $idUsuario . ') AS c on e.id_edicion = c.edicion 
                WHERE p.id_producto= ' . $id;

        return $this->database->query($sql);
    }

    public function setCompra($usuario, $edicion)
    {
        $sql = "INSERT INTO compra
                (fecha, usuario, edicion) 
                VALUES (CURRENT_DATE(),'$usuario','$edicion')";
        $this->database->execute($sql);
    }


    public function setProducto($nombre, $imagen, $tipo, $precio)
    {
        $sql = "INSERT INTO producto
                (`nombre`, `imagen`, `tipo`, `precio`) 
                VALUES ('$nombre', '$imagen', '$tipo', '$precio')";
        $this->database->execute($sql);
    }

    public function deleteProducto($id)
    {
        $sql = "DELETE FROM producto WHERE producto.id_producto=" . $id;
        $this->database->execute($sql);
    }


    public function getSuscripcion($id_producto, $id_usuario)
    {
        $sql = "SELECT DATEDIFF(CURRENT_DATE(), fecha) AS diferencia, fecha
            FROM suscripcion WHERE
            id_producto = '$id_producto' AND id_usuario ='$id_usuario'";

        return $this->database->query($sql);
    }


    public function setSuscripcion($id_producto, $id_usuario)
    {
        $sql = 'INSERT INTO suscripcion
            (fecha, id_producto, id_usuario, precio)
            VALUE (CURRENT_DATE(),' . $id_producto . ',' . $id_usuario . ',(SELECT precio from producto where id_producto =' . $id_producto . ' ))';

        $this->database->execute($sql);
    }


    public function updateProducto($idProducto, $nombre, $imagen, $tipo)
    {
        $sql = "UPDATE producto p SET p.nombre='$nombre',
                p.imagen='$imagen' ,p.tipo='$tipo'
                WHERE p.id_producto='$idProducto';";
        $this->database->execute($sql);
    }

    //ajax
    public function getEdicionesPorProductoAJax($id)
    {
        $sql = "SELECT * FROM edicion e JOIN producto p 
                    ON e.id_producto=p.id_producto WHERE p.id_producto =" . $id;
        $format = $this->database->query($sql);
        return print json_encode($format, JSON_UNESCAPED_UNICODE);
    }


    public function getEdicionesNoCompradas($id_producto, $idUsuario)
    {
        $sql = "SELECT e.fecha, e.id_edicion  
        from edicion e 
        where e.id_producto='$id_producto'
        and not exists (select c.id_compra
                            from compra c 
                            where c.edicion = e.id_edicion
                            and c.usuario ='$idUsuario')";
        return $this->database->query($sql);
    }

    public function getDiferenciaDeDias($fecha1, $fecha2)
    {

        $sql = "SELECT DATEDIFF(' . $fecha1 . ', ' . $fecha2 . ') AS diferencia";
        return $this->database->query($sql);

    }

}