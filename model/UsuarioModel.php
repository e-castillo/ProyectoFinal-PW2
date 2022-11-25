<?php

class UsuarioModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function getUsuarios()
    {
        $sql = "SELECT id_usuario,nombre, password,usuario,email,rol,activo,descripcion AS userRol FROM  usuario
        LEFT JOIN rol ON rol = id_rol;";
        return $this->database->query($sql);
    }

    public function setUsuarios($id_usuario, $rol)
    {
        $sql = "UPDATE usuario
        SET rol = '$rol',
            activo = 1 ,
            WHERE id_usuario = '$id_usuario'";

        $this->database->execute($sql);
    }

    public function getRoles()
    {
        $sql = "SELECT * FROM rol";
        return $this->database->query($sql);
    }

    public function darAlta($nombre, $usuario, $password, $email, $rol)
    {
        if (!$this->emailExistente($email)
            && !$this->userExistente($usuario)) {
            $passMd5 = md5($password);
            $sql = "INSERT INTO usuario (nombre,password,usuario,email,rol,activo)
                    VALUES('$nombre', '$passMd5','$usuario', '$email', '$rol', 1)";
            $this->database->execute($sql);
        } else{
            $status = "existente";
            return $status;
        }

    }

    private function emailExistente($email)
    {
        $sql = "SELECT 1 FROM usuario where email ='" . $email . "'";
        $result = $this->database->queryResult($sql);
        return (isset($result["1"]));

    }

    private function userExistente($user)
    {
        $sql = "SELECT 1 FROM usuario where usuario ='" . $user . "'";
        $result = $this->database->queryResult($sql);
        return (isset($result["1"]));

    }

    public function setUsuario($id_usuario, $rol,$activo){
        $sql="UPDATE usuario
        SET rol = '$rol', activo = '$activo'
        WHERE id_usuario = '$id_usuario'";

        $this->database->execute($sql);


    }

}