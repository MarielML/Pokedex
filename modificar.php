<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . "/Pokedex/BaseDeDatos/baseDeDatos.php");
$carpetaImagenes = __DIR__ . '/imagenes/';
$id = $_GET['id'];
$stmt = $conexion->prepare("SELECT * FROM pokemon WHERE id LIKE ?");
$param = $id;
$stmt->bind_param("s", $id);
$stmt->execute();
$resultado = $stmt->get_result();
$pokemons = $resultado->fetch_all(MYSQLI_ASSOC);

function extractGetParameterOrDefault($param, $defaultValue = "", $dato)
{
    return isset($_POST[$param]) && $_POST[$param] !== $defaultValue ? $_POST[$param] : $dato;
}

function modificar($conexion, $param1, $param2, $id)
{
    $stmt = $conexion->prepare("UPDATE pokemon SET $param1 = ? WHERE id = ?");
    $stmt->bind_param("ss", $param2, $id);
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
    <h1>Modificar Pokemon</h1>
    <form method="post" enctype="multipart/form-data">
        <input type="number" id="numero" name="numero" placeholder="Número"><br><br>
        <input type="text" id="nombre" name="nombre" placeholder="Nombre"><br><br>

        <label for="tipo">Tipo:</label><br><br>
        <select id="tipo" name="tipo">
            <option value="actual">Tipo actual</option>
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

        <label for="eliminarImagen">
            <input type="checkbox" id="eliminarImagen" name="eliminarImagen">
            Eliminar imagen
        </label><br><br>

        <button type="submit" class="w3-button w3-blue">Modificar</button><br><br>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        foreach ($pokemons as $pokemon) {
            $numero = extractGetParameterOrDefault("numero", "", $pokemon["numero"]);
            $nombre = extractGetParameterOrDefault("nombre", "", $pokemon["nombre"]);
            $tipo = isset($_POST["tipo"]) && $_POST["tipo"] !== "actual" ? "tipos/" . $_POST["tipo"] . ".jpg" : $pokemon["tipo"];
            $descripcion = extractGetParameterOrDefault("descripcion", "", $pokemon["descripcion"]);
            $nombreImagenOriginal = $carpetaImagenes . $pokemon["nombre"] . ".jpg";
            $nombreImagenNuevo = $carpetaImagenes . $nombre . ".jpg";
            $nombreImagen = extractGetParameterOrDefault("nombre", "", $pokemon["nombre"]);
        }

        $stmt = $conexion->prepare("SELECT * FROM pokemon WHERE numero = ? AND id != ?");
        $stmt->bind_param("ss", $numero, $id);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows > 0) {
            echo "<p class='w3-text-red'>Ya existe un pokemon con ese número</p>";
        } else {
            $stmt = $conexion->prepare("SELECT * FROM pokemon WHERE nombre = ? AND id != ?");
            $stmt->bind_param("ss", $nombre, $id);
            $stmt->execute();
            $resultado = $stmt->get_result();
            if ($resultado->num_rows > 0) {
                echo "<p class='w3-text-red'>Ya existe un pokemon con ese nombre</p>";
            } else {
                if (isset($_POST["eliminarImagen"])) {
                    $imagen = "Sin imagen";
                    modificar($conexion, "numero", $numero, $id);
                    modificar($conexion, "nombre", $nombre, $id);
                    modificar($conexion, "tipo", $tipo, $id);
                    modificar($conexion, "descripcion", $descripcion, $id);
                    modificar($conexion, "imagen", $imagen, $id);
                } else {
                    if (
                        isset($_FILES["imagen"]) &&
                        $_FILES["imagen"]["error"] == 0 &&
                        $_FILES["imagen"]["size"] > 0
                    ) {
                        $extension = pathinfo($_FILES["imagen"]["name"], PATHINFO_EXTENSION);
                        if ($extension == "png" || $extension == 'jpg' || $extension == 'jpeg') {
                            $rutaImagen = $carpetaImagenes . $nombreImagen . '.jpg';
                            move_uploaded_file($_FILES["imagen"]["tmp_name"], $rutaImagen);
                            $imagen = "imagenes/" . $nombreImagen . ".jpg";
                            modificar($conexion, "numero", $numero, $id);
                            modificar($conexion, "nombre", $nombre, $id);
                            modificar($conexion, "tipo", $tipo, $id);
                            modificar($conexion, "descripcion", $descripcion, $id);
                            modificar($conexion, "imagen", $imagen, $id);
                        } else {
                            echo "<p class='w3-text-red'>Sólo puedes publicar imágenes png, jpg o jpeg</p>";
                        }
                    } else {
                        if (file_exists($nombreImagenOriginal)) {
                            $nombreImagenNuevo = $carpetaImagenes . $nombre . ".jpg";
                            rename($nombreImagenOriginal, $nombreImagenNuevo);
                        }
                      
                        foreach ($pokemons as $pokemon) {
                            if ($pokemon["imagen"] === "Sin imagen") {
                                $imagen = "Sin imagen";
                            } else {
                                $imagen = "imagenes/" . $nombre . ".jpg";
                            }
                        }

                        modificar($conexion, "numero", $numero, $id);
                        modificar($conexion, "nombre", $nombre, $id);
                        modificar($conexion, "tipo", $tipo, $id);
                        modificar($conexion, "descripcion", $descripcion, $id);
                    }
                }
            }
        }
    }
    $conexion->close();
    ?>

    <a href="index.php"><button class="w3-button w3-red">Cancelar</button></a>
</body>

</html>