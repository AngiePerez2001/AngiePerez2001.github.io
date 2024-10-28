<?php
// Conexión a la base de datos
$mysqli = new mysqli("localhost", "root", "", "inventario");

// Comprobar la conexión
if ($mysqli->connect_error) {
    die("Error de conexión: " . $mysqli->connect_error);
}

// Consulta para obtener todos los usuarios
$query = "SELECT id, usuario, es_admin FROM usuarios";
$result = $mysqli->query($query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuarios</title>
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
            max-width: 600px;
            width: 100%;
        }
        h1 {
            color: #333;
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: left;
        }
        th {
            background-color: #008CBA;
            color: white;
        }
        .button-container {
            margin-top: 20px;
            text-align: center;
        }
        .button-container a button {
            background-color: #008CBA;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .button-container a button:hover {
            background-color: #007bb5;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Lista de Usuarios</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Es Administrador</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['usuario']; ?></td>
                    <td><?php echo $row['es_admin'] ? 'Sí' : 'No'; ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        
        <div class="button-container">
            <!-- Modificamos el enlace para redirigir al login -->
            <a href="login.php">
                <button type="button">Regresar al Login</button>
            </a>
        </div>
    </div>
</body>
</html>

<?php
// Cerrar la conexión
$mysqli->close();
?>
