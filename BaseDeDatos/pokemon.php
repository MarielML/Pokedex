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

    public function obtenerCoincidenciasDeTipoNombreNumero($textoBuscado)
    {
        $stmt = $this->conexion->prepare("SELECT * FROM pokemon WHERE nombre LIKE ? OR (SUBSTRING_INDEX(tipo, '/', -1) LIKE ? AND SUBSTRING_INDEX(tipo, '.', 1) LIKE ?) OR numero LIKE ?");
        $param = "%$textoBuscado%";
        $stmt->bind_param("ssss", $param, $param, $param, $param);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function obtenerCoincidenciasDeTipo($textoBuscado)
    {
        $stmt = $this->conexion->prepare("SELECT * FROM pokemon WHERE SUBSTRING_INDEX(tipo, '/', -1) LIKE ? AND SUBSTRING_INDEX(tipo, '.', 1) LIKE ?");
        $param = "%$textoBuscado%";
        $stmt->bind_param("ss", $param, $param);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function obtenerCoincidenciasDeNumero($textoBuscado)
    {
        $stmt = $this->conexion->prepare("SELECT * FROM pokemon WHERE numero LIKE ?");
        $param = "%$textoBuscado%";
        $stmt->bind_param("s", $param);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function obtenerCoincidenciasDeNombre($textoBuscado)
    {
        $stmt = $this->conexion->prepare("SELECT * FROM pokemon WHERE nombre LIKE ?");
        $param = "%$textoBuscado%";
        $stmt->bind_param("s", $param);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    }

    public function obtenerCoincidenciasPor($categoriaObtenida,$textoBuscado)
    {
        return $categoriaObtenida->obtenerCoinciencias($textoBuscado,$this);
    }

    public function __destruct()
    {
        $this->conexion->close();
    }

}