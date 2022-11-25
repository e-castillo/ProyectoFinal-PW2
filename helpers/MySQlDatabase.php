<?php
class MySQlDatabase {
    private $conexion;

    public function __construct($host_param = null,$user_param= null,$pass_param= null,$db_param= null) {
        $config = parse_ini_file("configuration/config.ini");

        $host = $host_param ?:  $config['host'];
        $user = $user_param ?: $config['user'];
        $pass = $pass_param ?:  $config['pass'];
        $db = $db_param ?: $config['db'];

        $this->conexion = new mysqli(
            $host,
            $user,
            $pass,
            $db);
    }

    public function __destruct() {
        $this->conexion->close();
    }

    public function query($sql) {
        $respuesta = $this->conexion->query($sql);
        return $respuesta->fetch_all(MYSQLI_ASSOC);
    }

    public function queryResult($sql)
    {
        $comando = $this->conexion->prepare($sql);
        $comando->execute();
        $result = $comando->get_result();
        return $result->fetch_assoc();

    }

    public function execute($sql) {
        $this->conexion->query($sql);
    }

}