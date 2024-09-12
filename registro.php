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
        <label for="usuario">Nombre de usuario:</label>
        <input type="text" id="usuario" name="usuario" required><br><br>
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required><br><br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>
        <label for="clave">Contraseña:</label>
        <input type="password" id="clave" name="clave" required><br><br>
        <label for="rep-clave">Repetir Contraseña:</label>
        <input type="password" id="rep-clave" name="rep-clave" required><br><br>
        <button type="submit" class="w3-button w3-blue">Registrarse</button><br><br>
    </form>
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nombreUsuario = $_POST['usuario'];
        $nombre = $_POST['nombre'];
        $clave = $_POST['clave'];
        $email = $_POST['email'];
        $repClave = $_POST['rep-clave'];

        $stmt = $conexion->prepare("SELECT * FROM usuario WHERE usuario = ?");
        $stmt->bind_param("s", $nombreUsuario);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows > 0) {
            echo "<p class='w3-text-red'>El nombre de usuario ya está en uso.</p>";
        } else {
            $stmt = $conexion->prepare("SELECT * FROM usuario WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $resultado = $stmt->get_result();
            if ($resultado->num_rows > 0) {
                echo "<p class='w3-text-red'>El email ya está en uso</p>";
            } else {
                if ($clave === $repClave) {
                    $hashed_password = password_hash($clave, PASSWORD_DEFAULT);

                    $stmt = $conexion->prepare("INSERT INTO usuario (usuario, nombre, password, email) VALUES (?, ?, ?, ?)");
                    $stmt->bind_param("ssss", $nombreUsuario, $nombre, $hashed_password, $email);
                    if ($stmt->execute()) {
                        echo "<p>Registro exitoso</p>";
                    } else {
                        echo "Error: " . $stmt->error;
                    }
                } else {
                   echo "<p class='w3-text-red'>Las contraseñas no son iguales<p>";
                }
            }
        }
    }
    $conexion->close();
    ?>
    <a href="index.php"><button class="w3-button w3-red">Volver</button></a>
</body>

</html>