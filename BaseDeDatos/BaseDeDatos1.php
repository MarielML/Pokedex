<?php

class BaseDeDatos
{

    private $conexion;

    public function __construct($config)
    {
        $this->conexion=mysqli_connect($config["servername"],$config["username"],$config["password"],$config["dbname"]);
        if(!$this->conexion){
            die("la conexion fallo: " . mysqli_connect_error());
        }
    }

    public function consulta($query="SELECT * FROM pokemon")
    {
        $consulta=mysqli_query($this->conexion,$query);
        return mysqli_fetch_assoc($consulta);
    }

    public function insertPokemon($numero="", $nombre="", $tipo="", $descripcion="", $imagen="")
    {
        $stmt = $this->conexion->prepare("INSERT INTO pokemon (numero, nombre, tipo, descripcion, imagen) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $numero, $nombre, $tipo, $descripcion, $imagen);
        if ($stmt->execute()) {
            header('Location: index.php');
        } else {
            echo "Error: " . $stmt->error;
        }
    }


    public function __destruct()
    {
        mysqli_close($this->conexion);
    }
}