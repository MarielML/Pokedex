<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>

<body>
    <h1>Inicio de Sesión</h1>
    <form method="post" action="index.php">
        <label for="usuario">Nombre de usuario:</label>
        <input type="text" id="usuario" name="usuario" required><br><br>
        <label for="clave">Contraseña:</label>
        <input type="password" id="clave" name="clave" required><br><br>
        <button type="submit">Iniciar sesión</button>
    </form>
    <a href="registro.php">Registrarse</a>
</body>

</html>