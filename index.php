<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

// Verificar si el usuario es administrador
if (!$_SESSION['es_admin']) {
    $_SESSION['error'] = "Solo los administradores tienen acceso.";
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>bodega</title>
    <style>
        /* Estilos generales */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #2c3e50;
            background-color: #2980b9;
            padding: 20px;
            border-radius: 5px;
            color: white;
        }

        h2 {
            color: #2980b9;
            border-bottom: 2px solid #2980b9;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        a {
            display: inline-block;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        a:hover {
            background-color: #1abc9c;
        }

        /* Estructura de la página */
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        h2, a {
            width: 100%;
            max-width: 400px;
        }
        
        /* Espaciado entre secciones */
        h2 + a {
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
    <h1>Bienvenido al Sistema de Inventario</h1>
    
    <h2>Proveedores</h2>
    <a href="proveedores.php">Gestionar Proveedores</a>
    
    <h2>Clientes</h2>
    <a href="clientes.php">Gestionar Clientes</a>
    
    <h2>Productos</h2>
    <a href="productos.php">Gestionar Productos</a>
    
    <h2>Ventas</h2>
    <a href="ventas.php">Gestionar Ventas</a>
    
    <h2>Compras</h2>
    <a href="compras.php">Gestionar Compras</a>

    <h2>Crear usuario</h2>
    <a href="crearcuenta.php">Crear usuario</a>
</body>
</html>
