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

<body class="bg-gray-100 p-8">
    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . "/Pokedex/BaseDeDatos/baseDeDatos.php");
    include $_SERVER['DOCUMENT_ROOT'] . "/Pokedex/header.php";
    ?>

    <div class="buscador">
        <input class="border border-gray-400 p-2" placeholder="Ingresa el nombre, tipo o número de pokémon"
            type="text" />
        <button class="border border-gray-400 p-2">
            ¿Quién es este pokemon?
        </button>
    </div>

    <?php
    $stmt = $conexion->prepare("SELECT * FROM pokemon");
    $stmt->execute();
    $resultado = $stmt->get_result();
    $pokemons = $resultado->fetch_all(MYSQLI_ASSOC);
    ?>

    <table class="w-full border-collapse border border-gray-400">
        <thead>
            <tr>
                <th>
                    Imagen
                </th>
                <th>
                    Tipo
                </th>
                <th>
                    Número
                </th>
                <th>
                    Nombre
                </th>
                <?php if (isset($_SESSION['logueado'])): ?>
                    <th>
                        Acciones
                    </th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pokemons as $pokemon): ?>
                <tr>
                    <td class="border border-gray-400 p-2">
                        <a href="pokemon.php?id=<?php echo htmlspecialchars($pokemon['id']); ?>">
                            <img src="<?php echo htmlspecialchars($pokemon['imagen']); ?>" alt="imagen">
                        </a>
                    </td>
                    <td class="border border-gray-400 p-2">
                        <a href="pokemon.php?id=<?php echo htmlspecialchars($pokemon['id']); ?>">
                            <img src="<?php echo htmlspecialchars($pokemon['tipo']); ?>" alt="tipo">
                        </a>
                    </td>
                    <td class="border border-gray-400 p-2">
                        <a href="pokemon.php?id=<?php echo htmlspecialchars($pokemon['id']); ?>"><?php echo htmlspecialchars($pokemon['numero']); ?>
                        </a>
                    </td>
                    <td class="border border-gray-400 p-2">
                        <a href="pokemon.php?id=<?php echo htmlspecialchars($pokemon['id']); ?>"><?php echo htmlspecialchars($pokemon['nombre']); ?>
                        </a>
                    </td>
                    <?php if (isset($_SESSION['logueado'])): ?>
                        <div class="acciones">
                            <td>
                                <a href="modificar.php?id=<?php echo htmlspecialchars($pokemon['id']); ?>">
                                    <button>Modificación</button>
                                </a>
                                <a href="baja.php?id=<?php echo htmlspecialchars($pokemon['id']); ?>">
                                    <button type="submit">Baja</button>
                                </a>
                            </td>
                        </div>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>

    </table>

    <div class="agregar">
        <?php
        if (isset($_SESSION['logueado'])) {
            echo "<a href='agregar.php'><button>Agregar pokemon</button></a>";
        }
        ?>
    </div>

    <?php
    $stmt->close();
    $conexion->close();
    ?>



</body>

</html>