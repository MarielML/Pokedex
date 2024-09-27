<?php
session_start();
require_once(__DIR__ . "/BaseDeDatos/baseDeDatos.php");
$id = $_GET['id'];

$stmt = $conexion->prepare("DELETE FROM pokemon WHERE id = $id");
$stmt->execute();

header("Location: index.php");
exit();