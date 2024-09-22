<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . "/Pokedex/BaseDeDatos/baseDeDatos.php");
$carpetaImagenes = __DIR__ . '/imagenes/';
function extractGetParameterOrDefault($param, $defaultValue = "")
{
    return isset($_POST[$param]) && $_POST[$param] !== "" ? $_POST[$param] : $defaultValue;
}

function agregar($conexion, $numero, $nombre, $tipo, $descripcion, $imagen)
{
    $stmt = $conexion->prepare("INSERT INTO pokemon (numero, nombre, tipo, descripcion, imagen) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $numero, $nombre, $tipo, $descripcion, $imagen);
    if ($stmt->execute()) {
        header('Location: index.php');
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Indie+Flower&amp;display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="./css/estilos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>Pokedex</title>
</head>

<body class="form-agregar">
    <h1>Agregar Pokemon</h1>
    <form method="post" enctype="multipart/form-data">
        <input type="number" id="numero" name="numero" required placeholder="Número"><br><br>
        <input type="text" id="nombre" name="nombre" required placeholder="Nombre"><br><br>

        <label for="tipo">Tipo:</label><br><br>
        <select id="tipo" name="tipo">
            <option value="normal">Normal</option>
            <option value="fuego">Fuego</option>
            <option value="agua">Agua</option>
            <option value="planta">Planta</option>
            <option value="electrico">Eléctrico</option>
        </select><br><br>

        <label for="descripcion">Descripción:</label><br><br>
        <textarea id="descripcion" name="descripcion" rows="5" cols="33"></textarea><br><br>

        <label for="imagen">Imagen:</label><br><br>
        <input type="file" id="imagen" name="imagen"><br><br>

        <button type="submit" class="w3-button w3-blue">Agregar</button><br><br>
    </form>
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $numero = $_POST['numero'];
        $nombre = $_POST['nombre'];
        $tipo = "tipos/" . $_POST['tipo'] . ".jpg";
        $descripcion = extractGetParameterOrDefault("descripcion", "Sin descripción");

        $stmt = $conexion->prepare("SELECT * FROM pokemon WHERE numero = ?");
        $stmt->bind_param("s", $numero);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows > 0) {
            echo "<p class='w3-text-red'>Ya existe un pokemon con ese número</p>";
        } else {
            $stmt = $conexion->prepare("SELECT * FROM pokemon WHERE nombre = ?");
            $stmt->bind_param("s", $nombre);
            $stmt->execute();
            $resultado = $stmt->get_result();
            if ($resultado->num_rows > 0) {
                echo "<p class='w3-text-red'>Ya existe un pokemon con ese nombre</p>";
            } else {
                if (
                    isset($_FILES["imagen"]) &&
                    $_FILES["imagen"]["error"] == 0 &&
                    $_FILES["imagen"]["size"] > 0
                ) {
                    $extension = pathinfo($_FILES["imagen"]["name"], PATHINFO_EXTENSION);
                    if ($extension == "png" || $extension == 'jpg' || $extension == 'jpeg') {
                        $rutaImagen = $carpetaImagenes . $nombre . '.jpg';
                        move_uploaded_file($_FILES["imagen"]["tmp_name"], $rutaImagen);
                        $imagen = "imagenes/" . $nombre . ".jpg";
                        agregar($conexion, $numero, $nombre, $tipo, $descripcion, $imagen);
                    } else {
                        echo "<p class='w3-text-red'>Sólo puedes publicar imágenes png, jpg o jpeg</p>";
                    }
                } else {
                    $imagen = "Sin imagen";
                    agregar($conexion, $numero, $nombre, $tipo, $descripcion, $imagen);
                }
            }
        }
    }
    $conexion->close();
    ?>
    <a href="index.php"><button class="w3-button w3-red">Cancelar</button></a>
</body>

</html>