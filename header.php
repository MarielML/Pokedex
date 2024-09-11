<?php
session_start();
?>

<header>
    <nav>
        <div>
            <img src="" alt="logo">
        </div>
        <div>
            <h1>Pokedex</h1>
        </div>
        <?php if (isset($_SESSION['logueado'])): ?>
            <p>Usuario <?php echo htmlspecialchars($_SESSION['logueado']); ?></p>
            <a href="logout.php" class="w3-button w3-red">Cerrar sesión</a>
        <?php else: ?>
            <form method="post" class="login-form">
                <input type="text" id="usuario" name="usuario" placeholder="Usuario" required>
                <input type="password" id="clave" name="clave" required placeholder="Password">
                <button type="submit" class="w3-button w3-green">Ingresar</button>
                <a href="registro.php" class="w3-button w3-blue">Registrarse</a>
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
            $conexion->close();
            ?>
            <!-- <a href="login.php" class="w3-button w3-green">Iniciar sesión</a> -->

        <?php endif; ?>
    </nav>
</header>