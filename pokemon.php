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
<main>
    <section class="container">
        <?php foreach ($pokemons as $pokemon): ?>
            <div class="row mb-4">
                <div class="col-md-3">
                    <?php if ($pokemon['imagen'] === 'Sin imagen'): ?>
                        <p>Sin imagen</p>
                    <?php else: ?>
                        <img src="<?= htmlspecialchars($pokemon['imagen']); ?>" alt="imagen de pokemon" class="img-fluid">
                    <?php endif; ?>
                </div>

                <div class="col-md-9">
                    <h2 class="d-flex align-items-center">
                        <img src="<?= htmlspecialchars($pokemon['tipo']) ?>" alt="tipo de pokemon" class="img-fluid ms-3" style="max-width: 50px;">
                        <span class="ms-2">ID: <?= htmlspecialchars($pokemon['numero']); ?></span>
                        <?= "-" . htmlspecialchars($pokemon['nombre']); ?>
                    </h2>

                    <p><?= htmlspecialchars($pokemon['descripcion']); ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </section>

    <section class="position-relative d-flex justify-content-center">
        <a href="index.php">
            <button class="btn btn-danger m-3">Volver</button>
        </a>
    </section>
</main>
</body>

</html>