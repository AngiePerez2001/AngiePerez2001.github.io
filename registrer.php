<?php
include 'db.php';

if (isset($_POST['register'])) {
    $usuario = $_POST['usuario'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Insertar el usuario en la base de datos
    $query = $conn->prepare("INSERT INTO usuarios (usuario, password) VALUES (?, ?)");
    $query->bind_param("ss", $usuario, $password);

    if ($query->execute()) {
        echo "Usuario registrado exitosamente";
    } else {
        echo "Error al registrar usuario.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Usuario</title>
</head>
<body>
    <h2>Registrar Usuario</h2>
    <form method="POST" action="register.php">
        <input type="text" name="usuario" placeholder="Nombre de usuario" required>
        <input type="password" name="password" placeholder="Contraseña" required>
        <button type="submit" name="register">Registrar</button>
    </form>
</body>
</html>
