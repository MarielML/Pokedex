<?php
require_once(__DIR__ . "/fragments/helperTable.php");
require_once(__DIR__ . "/BaseDeDatos/pokemon.php");

function mostrarCuerpoDeTabla($pokemons)
{
    $path = isset($_SESSION['logueado']) ? "admin" : "cliente";
    switch ($path) {
        case "admin":
            mostrarCuerpoDeTablaAdministrador($pokemons);
            break;
        default:
            mostrarTablaCliente($pokemons);
            break;
    }
}

include $_SERVER['DOCUMENT_ROOT'] . "/Pokedex/header.php";
?>

<main>
    <section>
        <form method="POST" class="buscador">
            <select id="categorias" name="categorias" class="border border-gray-400 p-2">
                <option value="nombreTipoNumero">Nombre, tipo o número</option>
                <option value="nombre">Nombre</option>
                <option value="tipo">Tipo</option>
                <option value="numero">Número</option>
            </select>
            <input class="border border-gray-400 p-2" placeholder="Ingresa el nombre, tipo o número de pokemon"
                type="text" id="textoBuscado" name="textoBuscado" />
            <button class="border border-gray-400 p-2">
                ¿Quién es este pokemon?
            </button>
        </form>
    </section>
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
                <?php
                if (isset($_SESSION['logueado'])) {
                    mostrarAccionesSiEstaLogeado();
                }
                ?>

            </tr>
        </thead>
        <tbody>

            <?php
            $pokemon = new pokemon();
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (isset($_POST['categorias'])) {
                    $categoriaSeleccionada = $_POST['categorias'];
                }
                $textoBuscado = isset($_POST["textoBuscado"]) && $_POST["textoBuscado"] !== "" ? $_POST["textoBuscado"] : "";

                if ($textoBuscado == "" || $categoriaSeleccionada == "") {
                    $pokemons = $pokemon->obtenerTodosLosPokemons();
                } else {
                    if ($categoriaSeleccionada === "nombreTipoNumero") {
                        $pokemons = $pokemon->obtenerCoincidenciasDeTipoNombreNumero($textoBuscado);
                    } else if ($categoriaSeleccionada === "tipo") {
                        $pokemons = $pokemon->obtenerCoincidenciasDeTipo($textoBuscado);
                    } else if ($categoriaSeleccionada === "nombre") {
                        $pokemons = $pokemon->obtenerCoincidenciasDeNombre($textoBuscado);
                    } else {
                        $pokemons = $pokemon->obtenerCoincidenciasDeNumero($textoBuscado);
                    }
                }
            } else {
                $pokemons = $pokemon->obtenerTodosLosPokemons();
            }

            if (!count($pokemons) > 0) {
                echo "<p class='w3-text-red'>Pokemon no encontrado</p>";
                $pokemons = $pokemon->obtenerTodosLosPokemons();
            }
            mostrarCuerpoDeTabla($pokemons);
            ?>

        </tbody>
    </table>

    <?php if (isset($_SESSION['logueado']))
        mostrarBotonAgregarPokemon();
    ?>
</main>
<script src="confirmarBaja.js"></script>

</body>

</html>