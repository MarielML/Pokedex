<?php
//los requiere siempre arriba asi se rompe la pagina si no funciona la parte requerida
require_once(__DIR__ . "/fragments/helperTable.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/Pokedex/BaseDeDatos/baseDeDatos.php");
require_once (__DIR__ . "/BaseDeDatos/pokemon.php");
function mostrarCuerpoDeTabla($pokemons)
{
    //este metodo ahora tiene una sola funcionalidad, que es imprimir los fragmentos de el cuerpo tabla
    $path=isset($_SESSION['logueado']) ?"admin" :"cliente";
    switch ($path){
        case "admin":
            //mostrarAccionesSiEstaLogeado(); -> mas adelante debe poder realizarlo por si solo,
            //por ahora veremos que podemos hacer con lo de mas abajo
            mostrarCuerpoDeTablaAdministrador($pokemons);
            //TODO:REVISAR PORQUE QUEDA ARRIBA
            mostrarBotonAgregarPokemon();
            break;
        default:
            mostrarTablaCliente($pokemons);
            break;
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
    <title>Pokedex</title>
</head>

<body class="bg-gray-100 p-8">
<?php
include $_SERVER['DOCUMENT_ROOT'] . "/Pokedex/header.php";
?>

<section>
    <form method="GET" class="buscador">
        <label for="categorias"></label><select id="categorias" name="categorias">
            <option value="nombreTipoNumero">Nombre, tipo o número</option>
            <option value="nombre">Nombre</option>
            <option value="tipo">Tipo</option>
            <option value="numero">Número</option>
        </select>
        <label for="textoBuscado"></label><input class="border border-gray-400 p-2" placeholder="Ingresa el nombre, tipo o número de pokémon"
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
        if(isset($_SESSION['logueado'])){
            mostrarAccionesSiEstaLogeado();
        }
        ?>

    </tr>
    </thead>
    <tbody>

<?php
//TODO: Mi proximo paso al refactorizar seria realizar el polimorfismo dinamico
//por ahora lo que realize fue que mi objeto pokemon se encargue de las consultas a la base de datos asi queda mas limpio
$pokemon = new pokemon();
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    //por lo que entienda esta porcion de codigo esta buscando
    //si hay algo en categorias en el select
    if (isset($_GET['categorias'])) {
        //agarra esto mismo
        $categoriaSeleccionada = $_GET['categorias'];
    }
    //consigue el texto buscado si hay algo en texto buscado y es diferente de vacio consigue el texto osino obtiene una cadena vacia
    $textoBuscado = isset($_GET["textoBuscado"]) && $_GET["textoBuscado"] !== "" ? $_GET["textoBuscado"] : "";
    if ($textoBuscado == "") {
        //si el texto buscado es igual a vacio obtiene todos los pokes
        //obtengo de mi objeto pokemon todos los pokemons delegando una unica responsabilidad a este objeto
        $pokemons = $pokemon->obtenerTodosLosPokemons();
    } else {
        //si el texto buscado es diferente a vacio revisa valida lo que hay en categoria
        //para poder refactorizar categoria podria aplicar polimorfismo dinamico
        if ($categoriaSeleccionada === "nombreTipoNumero") {
            //obtengo coincidencias segun nombreTipoNumero
            $pokemons = $pokemon->obtenerCoincidenciasDeTipoNombreNumero($textoBuscado);
        } else {
            //valida que la categoria sea igual a tipo
            if ($categoriaSeleccionada === "tipo") {
                $pokemons = $pokemon->obtenerCoincidenciasDeTipo($textoBuscado);
            } else if ($categoriaSeleccionada === "nombre") {
                $pokemons = $pokemon->obtenerCoincidenciasDeNombre($textoBuscado);
            } else {
                $pokemons = $pokemon->obtenerCoincidenciasDeNumero($textoBuscado);
            }
        }
   }
}else {
    $pokemons = $pokemon->obtenerTodosLosPokemons();
}

if (count($pokemons) > 0) {
    mostrarCuerpoDeTabla($pokemons);
} else {
    echo "<p class='w3-text-red'>Pokemon no encontrado</p>";
    $pokemons = $pokemon->obtenerTodosLosPokemons();
    mostrarCuerpoDeTabla($pokemons);
}
?>


    </tbody>
</table>

<script src="confirmarBaja.js"></script>

</body>

</html>