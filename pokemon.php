<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . "/Pokedex/BaseDeDatos/baseDeDatos.php");
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
        <a href="index.php">Volver</a>
    </section>
</body>

</html>