<?php
function mostrarTabla($pokemons)
{
    echo '<table class="w-full border-collapse border border-gray-400">
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
                </th>';
    if (isset($_SESSION['logueado'])) {
        echo '<th>
                        Acciones
                    </th>';
    }
    echo '</tr>
        </thead>
        <tbody>';
    foreach ($pokemons as $pokemon) {
        echo '<tr>
                    <td class="border border-gray-400 p-2">
                        <a href="pokemon.php?id=' . htmlspecialchars($pokemon['id']) . '">';
        if ($pokemon["imagen"] == "Sin imagen") {
            echo 'Sin imagen';
        } else {
            echo '<img src="' . htmlspecialchars($pokemon['imagen']) . '" alt="imagen">';
        }
        echo '</a>
                    </td>
                    <td class="border border-gray-400 p-2">
                        <a href="pokemon.php?id=' . htmlspecialchars($pokemon['id']) . '">
                            <img src="' . htmlspecialchars($pokemon['tipo']) . '" alt="tipo">
                        </a>
                    </td>
                    <td class="border border-gray-400 p-2">
                        <a href="pokemon.php?id=' . htmlspecialchars($pokemon['id']) . '">' . htmlspecialchars($pokemon['numero']) . '</a>
                    </td>
                    <td class="border border-gray-400 p-2">
                        <a href="pokemon.php?id=' . htmlspecialchars($pokemon['id']) . '">' . htmlspecialchars($pokemon['nombre']) . '</a>
                    </td>';
        if (isset($_SESSION['logueado'])) {
            echo '<td>
            <div class="acciones">
                                <a href="modificar.php?id=' . htmlspecialchars($pokemon['id']) . '">
                                    <button>Modificación</button>
                                </a>
                                <form action="baja.php?id=' . htmlspecialchars($pokemon['id']) . '" onsubmit="confirmarEliminacion(event)" method="post">
                                    <button type="submit">Baja</button>
                                    
                                </form>
                                </div>
                            </td>';
        }
        echo '</tr>';
    }
    echo '</tbody>

    </table>';
}

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

<body class="bg-gray-100 p-8">
    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . "/Pokedex/BaseDeDatos/baseDeDatos.php");
    include $_SERVER['DOCUMENT_ROOT'] . "/Pokedex/header.php";
    ?>

    <div>
        <form method="POST" class="buscador">
            <select id="categorias" name="categorias">
                <option value="nombreTipoNumero">Nombre, tipo o número</option>
                <option value="nombre">Nombre</option>
                <option value="tipo">Tipo</option>
                <option value="numero">Número</option>
            </select>
            <input class="border border-gray-400 p-2" placeholder="Ingresa el nombre, tipo o número de pokémon"
                type="text" id="textoBuscado" name="textoBuscado" />
            <button class="border border-gray-400 p-2">
                ¿Quién es este pokemon?
            </button>
        </form>
    </div>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['categorias'])) {
            $categoriaSeleccionada = $_POST['categorias'];
        }
        $textoBuscado = isset($_POST["textoBuscado"]) && $_POST["textoBuscado"] !== "" ? $_POST["textoBuscado"] : "";

        if ($textoBuscado == "") {
            $stmt = $conexion->prepare("SELECT * FROM pokemon");
        } else {
            if ($categoriaSeleccionada === "nombreTipoNumero") {
                $stmt = $conexion->prepare("SELECT * FROM pokemon WHERE nombre LIKE ? OR (SUBSTRING_INDEX(tipo, '/', -1) LIKE ? AND SUBSTRING_INDEX(tipo, '.', 1) LIKE ?) OR numero LIKE ?");
                $param = "%$textoBuscado%";
                $stmt->bind_param("ssss", $param, $param, $param, $param);
            } else {
                if ($categoriaSeleccionada === "tipo") {
                    $stmt = $conexion->prepare("SELECT * FROM pokemon WHERE SUBSTRING_INDEX(tipo, '/', -1) LIKE ? AND SUBSTRING_INDEX(tipo, '.', 1) LIKE ?");
                    $param = "%$textoBuscado%";
                    $stmt->bind_param("ss", $param, $param);
                } else {
                    $stmt = $conexion->prepare("SELECT * FROM pokemon WHERE $categoriaSeleccionada LIKE ?");
                    $param = "%$textoBuscado%";
                    $stmt->bind_param("s", $param);
                }
            }
        }
        $stmt->execute();
        $resultado = $stmt->get_result();
        $pokemons = $resultado->fetch_all(MYSQLI_ASSOC);
    } else {
        $stmt = $conexion->prepare("SELECT * FROM pokemon");
        $stmt->execute();
        $resultado = $stmt->get_result();
        $pokemons = $resultado->fetch_all(MYSQLI_ASSOC);
    }

    if (count($pokemons) > 0) {
        mostrarTabla($pokemons);
    } else {
        echo "<p class='w3-text-red'>Pokemon no encontrado</p>";
        $stmt = $conexion->prepare("SELECT * FROM pokemon");
        $stmt->execute();
        $resultado = $stmt->get_result();
        $pokemons = $resultado->fetch_all(MYSQLI_ASSOC);
        mostrarTabla($pokemons);
    }

    ?>

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

    <script src="confirmarBaja.js"></script>

</body>

</html>