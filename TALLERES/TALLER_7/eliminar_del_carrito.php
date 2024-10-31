<?php
include 'sesion_config.php';

if (isset($_POST['id'])) {
    $productoId = intval($_POST['id']);
    unset($_SESSION['carrito'][$productoId]);
    header("Location: ver_carrito.php");
    exit();
}
?>
