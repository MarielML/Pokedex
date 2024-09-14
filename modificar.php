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
            <option value="lucha">Lucha</option>
            <option value="volador">Volador</option>
            <option value="veneno">Veneno</option>
            <option value="tierra">Tierra</option>
            <option value="roca">Roca</option>
            <option value="bicho">Bicho</option>
            <option value="fantasma">Fantasma</option>
            <option value="acero">Acero</option>
            <option value="fuego">Fuego</option>
            <option value="agua">Agua</option>
            <option value="planta">Planta</option>
            <option value="electrico">Eléctrico</option>
            <option value="psiquico">Psíquico</option>
            <option value="hielo">Hielo</option>
            <option value="dragon">Dragón</option>
            <option value="hada">Hada</option>
            <option value="siniestro">Siniestro</option>
        </select><br><br>

        <label for="descripcion">Descripción:</label><br><br>
        <textarea id="descripcion" name="descripcion" rows="5" cols="33"></textarea><br><br>

        <label for="imagen">Imagen:</label><br><br>
        <input type="file" id="imagen" name="imagen"><br><br>

        <button type="submit" class="w3-button w3-blue">Modificar</button><br><br>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        foreach ($pokemons as $pokemon) {
            $numero = extractGetParameterOrDefault("numero", "", $pokemon["numero"]);
            $tipo = isset($_POST["tipo"]) && $_POST["tipo"] !== "actual" ? "imagenes/" . $_POST["tipo"] : $pokemon["tipo"];
        }
        
        echo $tipo;
        // $nombre = $_POST['nombre'];
        // $tipo = "imagenes/" . $_POST['tipo'] . ".jpg";
        // $descripcion = extractGetParameterOrDefault("descripcion", "Sin descripción");

        // $stmt = $conexion->prepare("SELECT * FROM pokemon WHERE numero = ?");
        // $stmt->bind_param("s", $numero);
        // $stmt->execute();
        // $resultado = $stmt->get_result();

        // if ($resultado->num_rows > 0) {
        //     echo "<p class='w3-text-red'>Ya existe un pokemon con ese número</p>";
        // } else {
        //     $stmt = $conexion->prepare("SELECT * FROM pokemon WHERE nombre = ?");
        //     $stmt->bind_param("s", $nombre);
        //     $stmt->execute();
        //     $resultado = $stmt->get_result();
        //     if ($resultado->num_rows > 0) {
        //         echo "<p class='w3-text-red'>Ya existe un pokemon con ese nombre</p>";
        //     } else {
        //         if (
        //             isset($_FILES["imagen"]) &&
        //             $_FILES["imagen"]["error"] == 0 &&
        //             $_FILES["imagen"]["size"] > 0
        //         ) {
        //             $extension = pathinfo($_FILES["imagen"]["name"], PATHINFO_EXTENSION);
        //             if ($extension == "png" || $extension == 'jpg' || $extension == 'jpeg') {
        //                 $rutaImagen = $carpetaImagenes . $nombre . '.jpg';
        //                 move_uploaded_file($_FILES["imagen"]["tmp_name"], $rutaImagen);
        //                 $imagen = "imagenes/" . $nombre . ".jpg";
        //                 agregar($conexion, $numero, $nombre, $tipo, $descripcion, $imagen);
        //             } else {
        //                 echo "<p class='w3-text-red'>Sólo puedes publicar imágenes png, jpg o jpeg</p>";
        //             }
        //         } else {
        //             $imagen = "Sin imagen";
        //             agregar($conexion, $numero, $nombre, $tipo, $descripcion, $imagen);
        //         }
        //     }
        // }
    }
    $conexion->close();
    ?>

    <a href="index.php"><button class="w3-button w3-red">Cancelar</button></a>
</body>

</html>