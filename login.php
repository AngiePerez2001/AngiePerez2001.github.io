<?php
// Conexión a la base de datos
$mysqli = new mysqli("localhost", "root", "", "inventario");

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    // Consulta a la base de datos para verificar credenciales
    $query = "SELECT * FROM usuarios WHERE usuario = '$usuario' AND password = '$password'";
    $result = $mysqli->query($query);

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        // Guardamos la información del usuario en la sesión
        $_SESSION['usuario'] = $user['usuario'];
        $_SESSION['es_admin'] = $user['es_admin']; // Esto será TRUE si es admin

        if ($_SESSION['es_admin']) {
            // Si es administrador, redirigimos al index
            header("Location: index.php");
            exit;
        } else {
            // Si no es administrador, mostrar mensaje y bloquear el acceso
            $_SESSION['error'] = "Solo los administradores tienen acceso.";
            header("Location: login.php");
            exit;
        }
    } else {
        // Si las credenciales no son correctas
        $_SESSION['error'] = "Usuario o contraseña incorrectos.";
        header("Location: login.php");
        exit;
    }
}
?>

<!-- Formulario de inicio de sesión -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            max-width: 400px;
            width: 100%;
            text-align: center;
        }

        h1 {
            color: #333;
            margin-bottom: 20px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        a {
            display: block;
            margin-top: 20px;
            color: #008CBA;
            text-decoration: none;
        }

        a:hover {
            color: #005f6b;
        }

        /* Estilo para el mensaje de error */
        .error-message {
            color: red;
            margin-bottom: 20px;
        }

        /* Estilo para la ventana modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: white;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 30%;
            text-align: center;
            border-radius: 10px;
        }

        .close {
            color: red;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover {
            color: darkred;
        }

    </style>
</head>
<body>

    <div class="container">
        <h1>Iniciar sesión</h1>

        <?php
        // Mostrar mensaje de error si existe
        if (isset($_SESSION['error'])) {
            echo "<p class='error-message'>" . $_SESSION['error'] . "</p>";
            unset($_SESSION['error']); // Limpiamos el mensaje de error después de mostrarlo
        }
        ?>

        <form method="POST" action="login.php">
            <input type="text" name="usuario" placeholder="Usuario" required><br>
            <input type="password" name="password" placeholder="Contraseña" required><br>
            <input type="submit" value="Iniciar sesión">
        </form>

        <a href="crearcuenta.php">Crear una cuenta</a>
    </div>

    <!-- Ventana modal que se mostrará si un usuario no administrador intenta acceder -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <p>Solo los administradores tienen acceso.</p>
        </div>
    </div>

    <script>
        // Mostrar la ventana modal si hay un error de acceso para usuarios no administradores
        <?php if (isset($_SESSION['error']) && $_SESSION['error'] == "Solo los administradores tienen acceso.") { ?>
            var modal = document.getElementById("myModal");
            modal.style.display = "block";
        <?php } ?>

        // Cerrar la ventana modal cuando se hace clic en "x"
        var closeBtn = document.getElementsByClassName("close")[0];
        closeBtn.onclick = function() {
            var modal = document.getElementById("myModal");
            modal.style.display = "none";
        }
    </script>
</body>
</html>



