<?php
session_start();
require_once("BaseDeDatos/baseDeDatos.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="./css/estilos.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Indie+Flower&amp;display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>Pokedex</title>
</head>

<body class="bg-gray-100 p-8">
    <header class="container py-3">
        <nav class="row align-items-center">
            <!-- Logo y título alineados a la izquierda -->
            <div class="col-6 d-flex align-items-center">
                <a href="index.php">
                    <img src="logo.jpg" alt="logo" class="img-fluid" style="width: 50px;">
                </a>
                <a href="index.php" class="ms-3">
                    <h1 class="fs-2">Pokedex</h1>
                </a>
            </div>

            <!-- Sección de login o cierre de sesión alineado a la derecha -->
            <div class="col-6 text-end">
                <?php if (isset($_SESSION['logueado'])): ?>
                    <div class="d-inline-block">
                        <p class="d-inline fs-4">Usuario <?php echo htmlspecialchars($_SESSION['logueado']); ?></p>
                        <a href="logout.php" class="ms-3">
                            <button class="btn btn-danger">Cerrar sesión</button>
                        </a>
                    </div>
                <?php else: ?>
                    <form method="post" class="d-inline-flex">
                        <input type="text" id="usuario" name="usuario" placeholder="Usuario"
                            class="form-control me-2" required>
                        <input type="password" id="clave" name="clave" required placeholder="Contraseña"
                            class="form-control me-2">
                        <button type="submit" class="btn btn-primary">Ingresar</button>
                    </form>

                    <?php
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        $nombreUsuario = isset($_POST['usuario']) && $_POST['usuario'] !== "" ? $_POST['usuario'] : "";
                        $clave = isset($_POST['clave']) && $_POST['clave'] !== "" ? $_POST['clave'] : "";

                        $stmt = $conexion->prepare("SELECT * FROM usuario WHERE usuario = ?");
                        $stmt->bind_param("s", $nombreUsuario);
                        $stmt->execute();
                        $resultado = $stmt->get_result();
                        $usuario = $resultado->fetch_assoc();

                        if ($nombreUsuario !== "" && $clave !== "") {
                            if ($usuario && password_verify($clave, password_hash($usuario['password'], PASSWORD_DEFAULT))) {
                                $_SESSION['logueado'] = $nombreUsuario;
                                header('Location: index.php');
                            } else {
                                echo "<p class='w3-text-red'>Usuario y/contraseña incorrectos</p>";
                            }
                        }
                        $stmt->close();
                    }
                    ?>
                <?php endif; ?>
            </div>
        </nav>
    </header>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>