<?php
session_start();
require_once("baseDeDatos.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>

<body>

    <h1>Inicio de Sesión</h1>
    <form method="post">
        <label for="usuario">Nombre de usuario:</label>
        <input type="text" id="usuario" name="usuario" required><br><br>
        <label for="clave">Contraseña:</label>
        <input type="password" id="clave" name="clave" required><br><br>
        <button type="submit" class="w3-button w3-green">Iniciar sesión</button><br><br>
    </form>
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nombreUsuario = $_POST['usuario'];
        $clave = $_POST['clave'];

        $stmt = $conexion->prepare("SELECT * FROM usuario WHERE usuario = ?");
        $stmt->bind_param("s", $nombreUsuario);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $usuario = $resultado->fetch_assoc();

        if ($nombreUsuario && password_verify($clave, $usuario['password'])) {
            $_SESSION['logueado'] = $nombreUsuario;
            header('Location: index.php');
        } else {
            echo "<p class='w3-text-red'>Usuario y/contraseña incorrectos</p>";
        }
        $stmt->close();  
    }
    $conexion->close();
    ?>

    <a href="registro.php"><button class="w3-button w3-blue">Registrarse</button></a><br><br>
    <a href="index.php"><button class="w3-button w3-red">Volver</button></a>
</body>

</html>