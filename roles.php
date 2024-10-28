<?php
include 'db.php';
// Supongamos que ya tienes la conexión a la base de datos
$email = 'admin@ejemplo.com'; // email del usuario que deseas verificar

// Consulta para verificar si el usuario puede crear otros usuarios
$sql = "SELECT COUNT(*) AS puede_crear
        FROM rol_permisos 
        WHERE rol_id = (SELECT rol_id FROM usuarios WHERE email = ?)
          AND permiso_id = (SELECT id FROM permisos WHERE nombre = 'crear usuarios')";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($row['puede_crear'] > 0) {
    echo "Este usuario puede crear otros usuarios.";
} else {
    echo "Este usuario no tiene permiso para crear usuarios.";
}

$stmt->close();
$conn->close();
?>
