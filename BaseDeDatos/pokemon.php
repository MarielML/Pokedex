<?php
require_once ("BaseDeDatos1.php");
class pokemon
{
    private $conexion;
    private $database;
    private $config;
    public function __construct()
    {
        $this->config=parse_ini_file("configlocal.ini");
        $this->database=new BaseDeDatos($this->config);
        $this->conexion=$this->database->getConexion();
    }


    public function obtenerTodosLosPokemons()
    {
        $stmt = $this->conexion->prepare("SELECT * FROM pokemon");
        $stmt->execute();
        $resultado = $stmt->get_result();
        return $resultado->fetch_all(MYSQLI_ASSOC);
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

}