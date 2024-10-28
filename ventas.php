<?php
// Incluir el archivo de conexión a la base de datos
include 'db.php';

// Ejecutar consulta para obtener las ventas
$sql = "SELECT ventas.id, clientes.nombre AS cliente_nombre, productos.nombre AS producto_nombre, ventas.cantidad, ventas.total, ventas.fecha 
        FROM ventas 
        JOIN clientes ON ventas.cliente_id = clientes.id 
        JOIN productos ON ventas.producto_id = productos.id";
$result = $conn->query($sql);

// Comprobar si la consulta fue exitosa
if (!$result) {
    die("Error en la consulta: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestionar Ventas</title>
    
    <!-- Incluir DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    
    <!-- Incluir jQuery y DataTables JS -->
    <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>

    <!-- Estilos personalizados -->
    <style>
        /* Estilos del formulario y la tabla */
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
            $('#ventasTable').DataTable(); // Inicializar DataTables en la tabla de ventas
        });
    </script>
</head>
<body>
    <h1>Gestionar Ventas</h1>
    
    <!-- Formulario para agregar una nueva venta -->
    <form method="POST" action="agregar_venta.php">
        <h2>Agregar Venta</h2>
        <label for="cliente_id">Cliente:</label>
        <select name="cliente_id" required>
            <?php 
            // Obtener clientes
            $clientes = $conn->query("SELECT * FROM clientes");
            while ($cliente = $clientes->fetch_assoc()) {
                echo "<option value='".$cliente['id']."'>".$cliente['nombre']."</option>";
            }
            ?>
        </select>
        
        <label for="producto_id">Producto:</label>
        <select name="producto_id" required>
            <?php 
            $productos = $conn->query("SELECT * FROM productos");
            while ($producto = $productos->fetch_assoc()) {
                echo "<option value='".$producto['id']."'>".$producto['nombre']."</option>";
            }
            ?>
        </select>

        <input type="number" name="cantidad" placeholder="Cantidad" required>
        <input type="number" step="0.01" name="total" placeholder="Total" required>
        <input type="date" name="fecha" required>
        <button type="submit" name="add_venta">Agregar Venta</button>
    </form>

    <h2>Lista de Ventas</h2>
    <!-- Tabla con DataTables -->
    <table id="ventasTable" class="display">
        <thead>
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Total</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['cliente_nombre']; ?></td>
                <td><?php echo $row['producto_nombre']; ?></td>
                <td><?php echo $row['cantidad']; ?></td>
                <td><?php echo $row['total']; ?></td>
                <td><?php echo $row['fecha']; ?></td>
                <td>
                    <a href="editar_venta.php?id=<?php echo $row['id']; ?>">Editar</a>
                    <a href="eliminar_venta.php?id=<?php echo $row['id']; ?>" onclick="return confirm('¿Estás seguro de que quieres eliminar esta venta?');">Eliminar</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <!-- Formulario para editar una venta (opcional) -->
    <?php if (isset($_GET['edit'])): 
        $id = $_GET['edit'];
        $venta = $conn->query("SELECT * FROM ventas WHERE id=$id")->fetch_assoc();
    ?>
    <h2>Editar Venta</h2>
    <form method="POST" action="actualizar_venta.php">
        <input type="hidden" name="id" value="<?php echo $venta['id']; ?>">
        
        <label for="cliente_id">Cliente:</label>
        <select name="cliente_id" required>
            <?php 
            $clientes = $conn->query("SELECT * FROM clientes");
            while ($cliente = $clientes->fetch_assoc()) {
                $selected = $cliente['id'] == $venta['cliente_id'] ? 'selected' : '';
                echo "<option value='".$cliente['id']."' $selected>".$cliente['nombre']."</option>";
            }
            ?>
        </select>
        
        <label for="producto_id">Producto:</label>
        <select name="producto_id" required>
            <?php 
            $productos = $conn->query("SELECT * FROM productos");
            while ($producto = $productos->fetch_assoc()) {
                $selected = $producto['id'] == $venta['producto_id'] ? 'selected' : '';
                echo "<option value='".$producto['id']."' $selected>".$producto['nombre']."</option>";
            }
            ?>
        </select>
        
        <input type="number" name="cantidad" value="<?php echo $venta['cantidad']; ?>" required>
        <input type="number" step="0.01" name="total" value="<?php echo $venta['total']; ?>" required>
        <input type="date" name="fecha" value="<?php echo $venta['fecha']; ?>" required>
        <button type="submit" name="update_venta">Actualizar Venta</button>
    </form>
    <?php endif; ?>
</body>
</html>


