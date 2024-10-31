<?php
include 'sesion_config.php';

// Ejemplo de productos
$productos = [
    ['id' => 1, 'nombre' => 'Arroz', 'precio' => 10.00],
    ['id' => 2, 'nombre' => 'Molde De Pan', 'precio' => 15.00],
    ['id' => 3, 'nombre' => 'Leche', 'precio' => 20.00],
    ['id' => 4, 'nombre' => 'HUEVOS', 'precio' => 25.00],
    ['id' => 5, 'nombre' => 'Pollo', 'precio' => 30.00],
];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Productos</title>
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
    <h1>Lista de Productos</h1>
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($productos as $producto): ?>
                <tr>
                    <td><?php echo htmlspecialchars($producto['nombre']); ?></td>
                    <td>$<?php echo number_format($producto['precio'], 2); ?></td>
                    <td>
                        <form action="agregar_al_carrito.php" method="post" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $producto['id']; ?>">
                            <input type="submit" value="Añadir al Carrito">
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="ver_carrito.php">Ver Carrito</a>
</body>
</html>