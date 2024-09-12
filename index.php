<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="./css/estilos.css">
</head>

<body>
    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . "/Pokedex/BaseDeDatos/baseDeDatos.php");
    include $_SERVER['DOCUMENT_ROOT'] . "/Pokedex/header.php";
    $stmt = $conexion->prepare("SELECT * FROM pokemon");
    $stmt->execute();
    $resultado = $stmt->get_result();
    $pokemons = $resultado->fetch_all(MYSQLI_ASSOC);
    ?>
    <?php foreach ($pokemons as $pokemon): ?>
        <div class="pokemon">
            <a href="pokemon.php?id=<?php echo htmlspecialchars($pokemon['id']); ?>"><?php echo htmlspecialchars($pokemon['nombre']); ?>
            </a>
        </div>
        <?php
        if (isset($_SESSION['logueado'])) {
            echo "<a><button>Modificar</button></a>";
        }
        ?>
    <?php endforeach; ?>
    <?php
    if (isset($_SESSION['logueado'])) {
        echo "<div><a><button>Agregar pokemon</button></a></div>";
    }
    $stmt->close();
    $conexion->close();
    ?>

</body>

</html>