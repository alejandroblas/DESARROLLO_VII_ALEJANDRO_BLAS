<?php
include 'config_sesion.php';

// Procesar la compra
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_SESSION['carrito'])) {
        // Guardar el resumen de la compra
        $resumenCompra = $_SESSION['carrito'];
        $totalCompra = 0;
        foreach ($resumenCompra as $producto) {
            $totalCompra += $producto['precio'] * $producto['cantidad'];
        }
        
        // Limpiar el carrito
        unset($_SESSION['carrito']);
        
        // Configurar cookie con el nombre de usuario
        if (isset($_POST['username'])) {
            setUserCookie($_POST['username']);
        }
        
        echo "<h1>Compra Realizada</h1>";
        echo "<p>Gracias por tu compra. Total: $$totalCompra</p>";
    } else {
        echo "<h1>Tu carrito está vacío.</h1>";
    }
} else {
    echo '<form method="post">
            <label for="username">Nombre:</label>
            <input type="text" name="username" required>
            <input type="submit" value="Finalizar Compra">
          </form>';
}
?>
