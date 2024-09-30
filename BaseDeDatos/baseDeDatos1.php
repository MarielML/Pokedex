<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/Pokedex/BaseDeDatos/BaseDeDatos.php");

$config = parse_ini_file("BaseDeDatos/configlocal.ini");
$database = new BaseDeDatos($config);
$conexion = $database->getConexion();
