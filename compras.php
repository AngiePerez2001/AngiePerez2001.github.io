<?php
include 'db.php'; // Asegúrate de que este archivo inicialice la variable $conn correctamente

// Función para evitar inyección SQL
function escape($data, $conn) {
    return mysqli_real_escape_string($conn, trim($data));
}

// Crear
if (isset($_POST['add_compra'])) {
    $id_cliente = escape($_POST['id_cliente'], $conn);
    $nombre_producto = escape($_POST['nombre_producto'], $conn); 
    $cantidad = escape($_POST['cantidad'], $conn);
    $precio = escape($_POST['precio'], $conn);
    $total = $cantidad * $precio;

    // Inserción corregida con sentencias preparadas
    $stmt = $conn->prepare("INSERT INTO compras (id_cliente, nombre_producto, cantidad, precio, total) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("isidd", $id_cliente, $nombre_producto, $cantidad, $precio, $total);
    
    if (!$stmt->execute()) {
        echo "Error al agregar compra: " . $stmt->error;
    }
    $stmt->close();
}

// Leer
$result = $conn->query("SELECT compras.*, clientes.nombre AS cliente_nombre FROM compras JOIN clientes ON compras.id_cliente = clientes.id");

// Actualizar
if (isset($_POST['update_compra'])) {
    $id = escape($_POST['id'], $conn);
    $id_cliente = escape($_POST['id_cliente'], $conn);
    $nombre_producto = escape($_POST['nombre_producto'], $conn);
    $cantidad = escape($_POST['cantidad'], $conn);
    $precio = escape($_POST['precio'], $conn);
    $total = $cantidad * $precio;

    // Actualización corregida con sentencias preparadas
    $stmt = $conn->prepare("UPDATE compras SET id_cliente=?, nombre_producto=?, cantidad=?, precio=?, total=? WHERE id=?");
    $stmt->bind_param("isiddi", $id_cliente, $nombre_producto, $cantidad, $precio, $total, $id);
    
    if (!$stmt->execute()) {
        echo "Error al actualizar compra: " . $stmt->error;
    }
    $stmt->close();
}

// Eliminar
if (isset($_GET['delete'])) {
    $id = escape($_GET['delete'], $conn);

    // Eliminación corregida con sentencias preparadas
    $stmt = $conn->prepare("DELETE FROM compras WHERE id=?");
    $stmt->bind_param("i", $id);
    
    if (!$stmt->execute()) {
        echo "Error al eliminar compra: " . $stmt->error;
    }
    $stmt->close();
}

// No cerrar la conexión aquí si se usa más tarde
?>



