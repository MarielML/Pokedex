<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . "/Pokedex/BaseDeDatos/baseDeDatos.php");
$id = $_GET['id'];

$stmt = $conexion->prepare("DELETE FROM pokemon WHERE id = $id");
$stmt->execute();

header("Location: index.php");