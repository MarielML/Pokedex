<?php
session_start();

$usuario = $_POST["usuario"];
$clave = $_POST["clave"];

if ($usuario == "pepe" && $clave == "12345") {
    $_SESSION["logueado"] = $usuario;
    header("Location: index.php");
    exit();
} else {
    header("Location: login.php");
    exit();
}