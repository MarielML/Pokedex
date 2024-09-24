<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Indie+Flower&amp;display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

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
    <section class="container">
        <?php foreach ($pokemons as $pokemon): ?>
            <div class="row mb-4">
                <div class="col-md-3">
                    <img src="<?= htmlspecialchars($pokemon['imagen']); ?>" alt="imagen de pokemon" class="img-fluid">
                </div>

                <div class="col-md-9">
                    <h2 class="d-flex align-items-center">
                        <img src="<?= htmlspecialchars($pokemon['tipo'])?>" alt="tipo de pokemon" class="img-fluid ms-3" style="max-width: 50px;">
                        <span class="ms-2">ID: <?= htmlspecialchars($pokemon['numero']); ?></span>
                        <?= "-" . htmlspecialchars($pokemon['nombre']); ?>
                    </h2>

                    <p><?= htmlspecialchars($pokemon['descripcion']); ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </section>

    <section class="position-relative">
        <a href="index.php">
            <button class="btn btn-danger position-absolute bottom-0 end-0 m-3">Volver</button>
        </a>
    </section>
</body>

</html>