<?php
session_start();
?>
<header>
    <nav>
        <?php if (isset($_SESSION['logueado'])): ?>
            <p>Usuario <?php echo htmlspecialchars($_SESSION['logueado']); ?></p>
            <a href="logout.php" class="w3-button w3-red">Cerrar sesión</a>
        <?php else: ?>
            <a href="login.php" class="w3-button w3-green">Iniciar sesión</a>
            <a href="registro.php" class="w3-button w3-blue">Registrarse</a>
        <?php endif; ?>
    </nav>
</header>