<?php

class BaseDeDatos
{

    private $conexion;

    public function __construct($config)
    {
        $this->conexion = mysqli_connect($config["servername"], $config["username"], $config["password"], $config["dbname"]);
        if (!$this->conexion) {
            die("la conexion fallo: " . mysqli_connect_error());
        }
    }

    public function getConexion()
    {
        return $this->conexion;
    }
}
