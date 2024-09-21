<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/Pokedex/BaseDeDatos/baseDeDatos.php");

$tipo = '';
$nombre = '';
$numero = '';
$pokemons = [];

$stmt = $conexion->prepare("SELECT * FROM pokemon");
$stmt->execute();
$resultado = $stmt->get_result();
$pokemons = $resultado->fetch_all(MYSQLI_ASSOC);

//  if ($resultado->num_rows > 0) {
//      while ($row = $resultado->fetch_assoc()) {
//         $pokemons[] = $row;
//      }
//  }

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $categoriaSeleccionada = $_POST['categorias'];
    $textoBuscado = isset($_POST["textoBuscado"]) && $_POST["textoBuscado"] !== "" ? $_POST["textoBuscado"] : "";

    $stmt = $conexion->prepare("SELECT * FROM pokemon WHERE nombre LIKE ?");
    $param = "%$textoBuscado%";
    $stmt->bind_param("s", $textoBuscado);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $pokemons = $resultado->fetch_all(MYSQLI_ASSOC);
    header('Location: index.php');
}
        
    
    //     $sql = "SELECT * FROM pokemon WHERE $categoriaSeleccionada LIKE ?";

    //  $conditions = [];

    //  if ($tipo) {
    //      $conditions[] = "tipo LIKE '%$tipo%'";
    //  }
    //  if ($nombre) {
    //      $conditions[] = "nombre LIKE '%$nombre%'";
    //  }
    //  if ($numero) {
    //      $conditions[] = "numero = '$numero'";
    //  }
    // }

//     $whereClause = '';
//     if (count($conditions) > 0) {
//         $whereClause = ' WHERE ' . implode(' AND ', $conditions);
//     }

//     $sql = "SELECT * FROM elementos" . $whereClause;
//     $result = $conn->query($sql);

//     $elementos = [];
//     if ($result->num_rows > 0) {
//         while ($row = $result->fetch_assoc()) {
//             $elementos[] = $row;
//         }
//     } else {
//         $elementos = null; // No se encontraron resultados
//     }
// }

// $conn->close();
