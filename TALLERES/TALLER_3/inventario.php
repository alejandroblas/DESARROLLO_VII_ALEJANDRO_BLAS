<?php

// Función para leer el inventario desde el archivo JSON
function leerInventario($archivo) {
    $contenido = file_get_contents($archivo);
    return json_decode($contenido, true);
}

// Función para ordenar el inventario alfabéticamente por nombre del producto
function ordenarInventarioPorNombre(&$inventario) {
    usort($inventario, function($a, $b) {
        return strcmp($a['nombre'], $b['nombre']);
    });
}

// Función para mostrar un resumen del inventario ordenado
//</br> es para salto de linea
function mostrarResumenInventario($inventario) {
    echo "Resumen del Inventario:\n";
    foreach ($inventario as $producto) {
        echo "</br>Nombre: {$producto['nombre']}, Precio: \${$producto['precio']}, Cantidad: {$producto['cantidad']}\n</br>";
    }
}

// Función para calcular el valor total del inventario
function calcularValorTotal($inventario) {
    $total = array_sum(array_map(function($producto) {
        return $producto['precio'] * $producto['cantidad'];
    }, $inventario));
    return $total;
}

// Función para generar un informe de productos con stock bajo
function generarInformeStockBajo($inventario) {
    $productosBajos = array_filter($inventario, function($producto) {
        return $producto['cantidad'] < 5;
    });
    return $productosBajos;
}

// Script principal
$archivo = 'inventario.json';
$inventario = leerInventario($archivo);

// Ordenar el inventario
ordenarInventarioPorNombre($inventario);

// Mostrar resumen del inventario
mostrarResumenInventario($inventario);

// Calcular y mostrar el valor total del inventario
$valorTotal = calcularValorTotal($inventario);
echo "\nValor Total del Inventario: \${$valorTotal}\n";

// Generar y mostrar informe de stock bajo
$productosBajos = generarInformeStockBajo($inventario);
if (!empty($productosBajos)) {
    echo "\nProductos con stock bajo:\n";
    foreach ($productosBajos as $producto) {
        echo "Nombre: {$producto['nombre']}, Cantidad: {$producto['cantidad']}\n";
    }
} else {
    echo "\nNo hay productos con stock bajo.\n";
}
?>