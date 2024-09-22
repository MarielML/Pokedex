<?php
session_start();
?>


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
                    $nombreUsuario = $_POST['usuario'];
                    $clave = $_POST['clave'];

                    $stmt = $conexion->prepare("SELECT * FROM usuario WHERE usuario = ?");
                    $stmt->bind_param("s", $nombreUsuario);
                    $stmt->execute();
                    $resultado = $stmt->get_result();
                    $usuario = $resultado->fetch_assoc();

                    if ($usuario && password_verify($clave, password_hash($usuario['password'], PASSWORD_DEFAULT))) {
                        $_SESSION['logueado'] = $nombreUsuario;
                        header('Location: index.php');
                    } else {
                        echo "<p class='text-danger'>Usuario y/o contraseña incorrectos</p>";
                    }
                    $stmt->close();
                }
                ?>
            <?php endif; ?>
        </div>
    </nav>
</header>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
