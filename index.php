<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/Pokedex/BaseDeDatos/baseDeDatos.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="./css/estilos.css">
</head>

<body>
    <?php
    include $_SERVER['DOCUMENT_ROOT'] . "/Pokedex/header.php";
    if (isset($_SESSION["logueado"]))
    ?>
</body>

</html>