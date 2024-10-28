<?php
include 'db.php';

// Crear
if (isset($_POST['add_cliente'])) {
    $nombre = $_POST['nombre'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];

    $stmt = $conn->prepare("INSERT INTO clientes (nombre, direccion, telefono, email) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nombre, $direccion, $telefono, $email);
    $stmt->execute();
}

// Leer
$result = $conn->query("SELECT * FROM clientes");

// Actualizar
if (isset($_POST['update_cliente'])) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];

    $stmt = $conn->prepare("UPDATE clientes SET nombre=?, direccion=?, telefono=?, email=? WHERE id=?");
    $stmt->bind_param("ssssi", $nombre, $direccion, $telefono, $email, $id);
    $stmt->execute();
}

// Eliminar
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM clientes WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestionar Clientes</title>

    <!-- Incluir DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">

    <!-- Incluir jQuery y DataTables JS -->
    <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }

        h1 {
            color: #2c3e50;
            text-align: center;
        }

        form {
            margin-bottom: 20px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        form h2 {
            margin-bottom: 20px;
            color: #2980b9;
        }

        input, select, button {
            display: block;
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 4px;
            border: 1px solid #ddd;
        }

        button {
            background-color: #3498db;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #2980b9;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #2980b9;
            color: white;
        }

        a {
            color: #3498db;
            text-decoration: none;
            margin-right: 10px;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>

    <script>
        $(document).ready(function() {
            $('#clientesTable').DataTable(); // Inicializar DataTables
        });
    </script>
</head>
<body>
    <h1>Gestionar Clientes</h1>

    <!-- Formulario para agregar un nuevo cliente -->
    <?php if (!isset($_GET['edit'])): ?>
    <form method="POST" action="">
        <h2>Agregar Cliente</h2>
        <input type="text" name="nombre" placeholder="Nombre" required>
        <input type="text" name="direccion" placeholder="Dirección" required>
        <input type="text" name="telefono" placeholder="Teléfono" required>
        <input type="email" name="email" placeholder="Email" required>
        <button type="submit" name="add_cliente">Agregar Cliente</button>
    </form>
    <?php endif; ?>

    <!-- Formulario para editar un cliente -->
    <?php if (isset($_GET['edit'])): 
        $id = $_GET['edit'];
        $stmt = $conn->prepare("SELECT * FROM clientes WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $cliente = $resultado->fetch_assoc();
    ?>
    <h2>Editar Cliente</h2>
    <form method="POST" action="">
        <input type="hidden" name="id" value="<?php echo $cliente['id']; ?>">
        <input type="text" name="nombre" value="<?php echo $cliente['nombre']; ?>" required>
        <input type="text" name="direccion" value="<?php echo $cliente['direccion']; ?>" required>
        <input type="text" name="telefono" value="<?php echo $cliente['telefono']; ?>" required>
        <input type="email" name="email" value="<?php echo $cliente['email']; ?>" required>
        <button type="submit" name="update_cliente">Actualizar Cliente</button>
    </form>
    <?php endif; ?>

    <h2>Lista de Clientes</h2>
    <!-- Tabla de clientes con DataTables -->
    <table id="clientesTable" class="display">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Dirección</th>
                <th>Teléfono</th>
                <th>Email</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['nombre']; ?></td>
                <td><?php echo $row['direccion']; ?></td>
                <td><?php echo $row['telefono']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td>
                    <a href="?edit=<?php echo $row['id']; ?>">Editar</a>
                    <a href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('¿Estás seguro de que quieres eliminar este cliente?');">Eliminar</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>

