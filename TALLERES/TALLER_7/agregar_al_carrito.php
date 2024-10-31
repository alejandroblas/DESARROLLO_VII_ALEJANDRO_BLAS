<?php
include 'sesion_config.php';

if (isset($_POST['id'])) {
    $productoId = intval($_POST['id']);
    $nombreProducto = "Producto $productoId"; // Podrías buscar el nombre del producto en una base de datos
    $precioProducto = 10.00 * $productoId; // Simulación de precio

    // Inicializar carrito si no existe
    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = [];
    }

    // Añadir producto al carrito
    if (isset($_SESSION['carrito'][$productoId])) {
        $_SESSION['carrito'][$productoId]['cantidad']++;
    } else {
        $_SESSION['carrito'][$productoId] = [
            'nombre' => $nombreProducto,
            'precio' => $precioProducto,
            'cantidad' => 1
        ];
    }

    header("Location: productos.php");
    exit();
}
?>
