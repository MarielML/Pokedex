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

<body>
    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . "/Pokedex/BaseDeDatos/baseDeDatos.php");
    include $_SERVER['DOCUMENT_ROOT'] . "/Pokedex/header.php";
    $id = $_GET['id'];
    $stmt = $conexion->prepare("SELECT * FROM pokemon WHERE id LIKE ?");
    $param = $id;
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $pokemons = $resultado->fetch_all(MYSQLI_ASSOC);
    ?>
    <section>
        <?php foreach ($pokemons as $pokemon): ?>
            <h1><?= htmlspecialchars($pokemon['nombre']); ?></h1>
            <img src="<?php echo htmlspecialchars($pokemon['imagen']); ?>">
            <p><?= htmlspecialchars($pokemon['descripcion']); ?></p>
        <?php endforeach; ?>
    </section>

    <section class="volver">
        <a href="index.php"><button class="w3-button w3-red">Volver</button></a>
    </section>
</body>

</html>