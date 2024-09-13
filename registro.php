<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . "/Pokedex/BaseDeDatos/baseDeDatos.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokedex</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Indie+Flower&amp;display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="./css/estilos.css">
</head>

<body class="registro">
    <h1>Registrarse</h1>
    <form method="post">
        <input type="text" id="usuario" name="usuario" required placeholder="Nombre de usuario"><br><br>
        <input type="text" id="nombre" name="nombre" required placeholder="Nombre"><br><br>
        <input type="email" id="email" name="email" required placeholder="email"><br><br>
        <input type="password" id="clave" name="clave" required placeholder="contraseña"><br><br>
        <input type="password" id="rep-clave" name="rep-clave" required placeholder="Repetir Contraseña"><br><br>
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
            echo "<p class='w3-text-red'>El nombre de usuario ya está en uso</p>";
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