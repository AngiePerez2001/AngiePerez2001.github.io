<?php
// Conexión a la base de datos
$mysqli = new mysqli("localhost", "root", "", "inventario");

session_start();

// Comprobar si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nuevo_usuario = $_POST['nuevo_usuario'];
    $nuevo_password = $_POST['nuevo_password'];
    $es_admin = isset($_POST['es_admin']) ? 1 : 0;

    // Insertar nuevo usuario en la base de datos
    $query = "INSERT INTO usuarios (usuario, password, es_admin) VALUES ('$nuevo_usuario', '$nuevo_password', $es_admin)";
    if ($mysqli->query($query)) {
        echo "<p class='success'>Usuario creado exitosamente.</p>";
    } else {
        echo "<p class='error'>Error al crear usuario: " . $mysqli->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Cuenta</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            text-align: center;
        }
        h1 {
            color: #333;
        }
        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        input[type="text"],
        input[type="password"] {
            padding: 10px;
            margin: 10px 0;
            width: 100%;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="checkbox"] {
            margin-right: 10px;
        }
        label {
            display: flex;
            align-items: center;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .button-container {
            margin-top: 20px;
        }
        .button-container button {
            background-color: #008CBA;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .button-container button:hover {
            background-color: #007bb5;
        }
        .success {
            color: green;
        }
        .error {
            color: red;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Crear un nuevo usuario</h1>
        <form method="POST" action="crearcuenta.php">
            <input type="text" name="nuevo_usuario" placeholder="Nuevo usuario" required><br>
            <input type="password" name="nuevo_password" placeholder="Contraseña" required><br>
            <label>
                <input type="checkbox" name="es_admin"> ¿Es administrador?
            </label><br>
            <input type="submit" value="Crear usuario">
        </form>
        
        <div class="button-container">
            <a href="login.php">
                <button type="button">Regresar al Login</button>
            </a>
        </div>
    </div>

</body>
</html>

