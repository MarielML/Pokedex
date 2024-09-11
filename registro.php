<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . "/Pokedex/BaseDeDatos/baseDeDatos.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="./css/estilos.css">
</head>

<body>
    <h1>Registrarse</h1>
    <form method="post">
        <label for="username">Nombre de usuario:</label>
        <input type="text" id="usuario" name="usuario" required><br><br>
        <label for="password">Contraseña:</label>
        <input type="password" id="clave" name="clave" required><br><br>
        <button type="submit" class="w3-button w3-blue">Registrarse</button><br><br>
    </form>
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nombreUsuario = $_POST['usuario'];
        $clave = $_POST['clave'];

        $stmt = $conexion->prepare("SELECT * FROM usuario WHERE usuario = ?");
        $stmt->bind_param("s", $nombreUsuario);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows > 0) {
            echo "El nombre de usuario ya está en uso.";
        } else {
            $hashed_password = password_hash($clave, PASSWORD_DEFAULT);

            $stmt = $conexion->prepare("INSERT INTO usuario (usuario, password) VALUES (?, ?)");
            $stmt->bind_param("ss", $nombreUsuario, $hashed_password);
            if ($stmt->execute()) {
                echo "Registro exitoso.";
            } else {
                echo "Error: " . $stmt->error;
            }
        }
    }
    $conexion->close();
    ?>
    <a href="index.php"><button class="w3-button w3-red">Volver</button></a>
</body>

</html>