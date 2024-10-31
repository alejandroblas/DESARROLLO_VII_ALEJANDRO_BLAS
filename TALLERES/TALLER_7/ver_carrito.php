<?php

include 'sesion_config.php';

$total = 0;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Carrito</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Tu Carrito</h1>
    <table>
        <thead>
            <tr>
                <th>Producto</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php if (isset($_SESSION['carrito']) && !empty($_SESSION['carrito'])): ?>
                <?php foreach ($_SESSION['carrito'] as $id => $producto): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($producto['nombre']); ?></td>
                        <td>$<?php echo number_format($producto['precio'], 2); ?></td>
                        <td><?php echo $producto['cantidad']; ?></td>
                        <td>
                            <form action="eliminar_del_carrito.php" method="post" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo $id; ?>">
                                <input type="submit" value="Eliminar">
                            </form>
                        </td>
                    </tr>
                    <?php $total += $producto['precio'] * $producto['cantidad']; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">Tu carrito está vacío.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <h2>Total: $<?php echo number_format($total, 2); ?></h2>
    <a href="checkout.php">Proceder al Checkout</a>
</body>
</html>