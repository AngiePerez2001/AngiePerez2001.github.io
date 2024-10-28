<?php
include 'db.php'; // Conexión a la base de datos

// Crear
if (isset($_POST['add_producto'])) {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $cantidad = $_POST['cantidad'];

    $conn->query("INSERT INTO productos (nombre, descripcion, precio, cantidad) VALUES ('$nombre', '$descripcion', '$precio', '$cantidad')");
}

// Leer
$result = $conn->query("SELECT * FROM productos");

// Actualizar
if (isset($_POST['update_producto'])) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $cantidad = $_POST['cantidad'];

    $conn->query("UPDATE productos SET nombre='$nombre', descripcion='$descripcion', precio='$precio', cantidad='$cantidad' WHERE id=$id");
}

// Eliminar
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM productos WHERE id=$id");
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestionar Productos</title>

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

        input, button {
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
        $(document).ready( function () {
            $('#productosTable').DataTable(); // Inicializar DataTables
        });
    </script>
</head>
<body>
    <h1>Gestionar Productos</h1>

    <!-- Formulario para agregar o editar un producto -->
    <?php if (isset($_GET['edit'])): 
        $id = $_GET['edit'];
        $producto = $conn->query("SELECT * FROM productos WHERE id=$id")->fetch_assoc();
    ?>
    <form method="POST" action="">
        <h2>Editar Producto</h2>
        <input type="hidden" name="id" value="<?php echo $producto['id']; ?>">
        <input type="text" name="nombre" value="<?php echo $producto['nombre']; ?>" required>
        <input type="text" name="descripcion" value="<?php echo $producto['descripcion']; ?>" required>
        <input type="number" step="0.01" name="precio" value="<?php echo $producto['precio']; ?>" required>
        <input type="number" name="cantidad" value="<?php echo $producto['cantidad']; ?>" required>
        <button type="submit" name="update_producto">Actualizar Producto</button>
    </form>
    <?php else: ?>
    <form method="POST" action="">
        <h2>Agregar Producto</h2>
        <input type="text" name="nombre" placeholder="Nombre del Producto" required>
        <input type="text" name="descripcion" placeholder="Descripción" required>
        <input type="number" step="0.01" name="precio" placeholder="Precio" required>
        <input type="number" name="cantidad" placeholder="Cantidad" required>
        <button type="submit" name="add_producto">Agregar Producto</button>
    </form>
    <?php endif; ?>

    <h2>Lista de Productos</h2>
    <!-- Tabla de productos con ID para DataTables -->
    <table id="productosTable" class="display">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['nombre']; ?></td>
                <td><?php echo $row['descripcion']; ?></td>
                <td><?php echo $row['precio']; ?></td>
                <td><?php echo $row['cantidad']; ?></td>
                <td>
                    <a href="?edit=<?php echo $row['id']; ?>">Editar</a>
                    <a href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('¿Estás seguro de que quieres eliminar este producto?');">Eliminar</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
