<?php
session_start();
?>

<header>
    <nav>
        <div class="flex items-center">
            <div class="w-12 h-12 bg-gray-300 flex items-center justify-center">
                <img src="" alt="logo">
            </div>
        </div>
        <h1 class="text-4xl">
            Pokedex
        </h1>
        <div class="flex space-x-4">
            <?php if (isset($_SESSION['logueado'])): ?>
                <div class="cerrarSesion">
                    <p>Usuario <?php echo htmlspecialchars($_SESSION['logueado']); ?></p>
                    <a href="logout.php"><button class="w3-button w3-red">Cerrar sesión</button></a>
                </div>
            <?php else: ?>
                <form method="post" class="login-form">
                    <input type="text" id="usuario" name="usuario" placeholder="Usuario"
                        class="border border-gray-400 p-2 rounded" required>
                    <input type="password" id="clave" name="clave" required placeholder="Contraseña"
                        class="border border-gray-400 p-2 rounded">
                    <button type="submit" class="border border-gray-400 p-2 rounded w3-button w3-blue">Ingresar</button>
                    <a href="registro.php" class="border border-gray-400 p-2 rounded w3-button w3-blue">Registrarse</a>
                </form>

                <?php
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $nombreUsuario = $_POST['usuario'];
                    $clave = $_POST['clave'];

                    $stmt = $conexion->prepare("SELECT * FROM usuario WHERE usuario = ?");
                    $stmt->bind_param("s", $nombreUsuario);
                    $stmt->execute();
                    $resultado = $stmt->get_result();
                    $usuario = $resultado->fetch_assoc();

                    if ($usuario && password_verify($clave, $usuario['password'])) {
                        $_SESSION['logueado'] = $nombreUsuario;
                        header('Location: index.php');
                    } else {
                        echo "<p class='w3-text-red'>Usuario y/contraseña incorrectos</p>";
                    }
                    $stmt->close();
                }
                ?>
            <?php endif; ?>

        </div>
    </nav>

    <div class="buscador">
        <input class="border border-gray-400 p-2" placeholder="Ingresa el nombre, tipo o número de pokémon"
            type="text" />
        <button class="border border-gray-400 p-2">
            ¿Quién es este pokemon?
        </button>
    </div>

</header>