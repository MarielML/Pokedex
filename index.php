<?php
global $conexion;
//los requiere siempre arriba asi se rompe la pagina si no funciona la parte requerida
require_once(__DIR__ . "/fragments/helperTable.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/Pokedex/BaseDeDatos/baseDeDatos.php");
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
    <form method="POST" class="buscador">
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
    mostrarCuerpoDeTabla($pokemons);
} else {
    echo "<p class='w3-text-red'>Pokemon no encontrado</p>";
    $stmt = $conexion->prepare("SELECT * FROM pokemon");
    $stmt->execute();
    $resultado = $stmt->get_result();
    $pokemons = $resultado->fetch_all(MYSQLI_ASSOC);
    mostrarCuerpoDeTabla($pokemons);
}

?>


    </tbody>
</table>


<?php
$stmt->close();
$conexion->close();
?>

<script src="confirmarBaja.js"></script>

</body>

</html>