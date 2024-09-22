<?php
// 1. Crear un string JSON con datos de una tienda en línea
$jsonDatos = '
{
    "tienda": "ElectroTech",
    "productos": [
        {"id": 1, "nombre": "Laptop Gamer", "precio": 1200, "categorias": ["electrónica", "computadoras"]},
        {"id": 2, "nombre": "Smartphone 5G", "precio": 800, "categorias": ["electrónica", "celulares"]},
        {"id": 3, "nombre": "Auriculares Bluetooth", "precio": 150, "categorias": ["electrónica", "accesorios"]},
        {"id": 4, "nombre": "Smart TV 4K", "precio": 700, "categorias": ["electrónica", "televisores"]},
        {"id": 5, "nombre": "Tablet", "precio": 300, "categorias": ["electrónica", "computadoras"]}
    ],
    "clientes": [
        {"id": 101, "nombre": "Ana López", "email": "ana@example.com"},
        {"id": 102, "nombre": "Carlos Gómez", "email": "carlos@example.com"},
        {"id": 103, "nombre": "María Rodríguez", "email": "maria@example.com"}
    ]
}
';

// 2. Convertir el JSON a un arreglo asociativo de PHP
$tiendaData = json_decode($jsonDatos, true);

// 3. Función para imprimir los productos
function imprimirProductos($productos) {
    foreach ($productos as $producto) {
        echo "</br>{$producto['nombre']} - \${$producto['precio']} - Categorías: " . implode(", ", $producto['categorias']) . "\n";
    }
}

echo "</br>Productos de {$tiendaData['tienda']}:\n";
imprimirProductos($tiendaData['productos']);

// 4. Calcular el valor total del inventario
$valorTotal = array_reduce($tiendaData['productos'], function($total, $producto) {
    return $total + $producto['precio'];
}, 0);
echo"</br>---------------------------------------------------------------------------------------------------------------";
echo "</br>\nValor total del inventario: \$$valorTotal\n";

// 5. Encontrar el producto más caro
$productoMasCaro = array_reduce($tiendaData['productos'], function($max, $producto) {
    return ($producto['precio'] > $max['precio']) ? $producto : $max;
}, $tiendaData['productos'][0]);

echo "</br>\nProducto más caro: {$productoMasCaro['nombre']} (\${$productoMasCaro['precio']})\n";

// 6. Filtrar productos por categoría
function filtrarPorCategoria($productos, $categoria) {
    return array_filter($productos, function($producto) use ($categoria) {
        return in_array($categoria, $producto['categorias']);
    });
}

$productosDeComputadoras = filtrarPorCategoria($tiendaData['productos'], "computadoras");
echo "</br>\nProductos en la categoría 'computadoras':\n";
imprimirProductos($productosDeComputadoras);

// 7. Agregar un nuevo producto
$nuevoProducto = [
    "id" => 6,
    "nombre" => "Smartwatch",
    "precio" => 250,
    "categorias" => ["electrónica", "accesorios", "wearables"]
];
$tiendaData['productos'][] = $nuevoProducto;

// 8. Crear un arreglo de ventas
$ventas = [
    ["producto_id" => 1, "cliente_id" => 101, "cantidad" => 1, "fecha" => "2024-09-01"],
    ["producto_id" => 2, "cliente_id" => 102, "cantidad" => 2, "fecha" => "2024-09-02"],
    ["producto_id" => 3, "cliente_id" => 103, "cantidad" => 1, "fecha" => "2024-09-03"],
    ["producto_id" => 1, "cliente_id" => 101, "cantidad" => 1, "fecha" => "2024-09-04"],
    ["producto_id" => 4, "cliente_id" => 102, "cantidad" => 1, "fecha" => "2024-09-05"],
];

// 9. Función para generar un resumen de ventas
function resumenVentas($ventas, $productos, $clientes) {
    $totalVentas = 0;
    $productoVendidos = [];
    $clienteCompras = [];

    foreach ($ventas as $venta) {
        // Calcular total de ventas
        $producto = array_filter($productos, fn($p) => $p['id'] === $venta['producto_id']);
        $producto = array_values($producto)[0] ?? null;

        if ($producto) {
            $total = $producto['precio'] * $venta['cantidad'];
            $totalVentas += $total;

            // Contar cantidad de cada producto vendido
            if (!isset($productoVendidos[$venta['producto_id']])) {
                $productoVendidos[$venta['producto_id']] = 0;
            }
            $productoVendidos[$venta['producto_id']] += $venta['cantidad'];

            // Contar compras de cada cliente
            if (!isset($clienteCompras[$venta['cliente_id']])) {
                $clienteCompras[$venta['cliente_id']] = 0;
            }
            $clienteCompras[$venta['cliente_id']] += $venta['cantidad'];
        }
    }

    // Producto más vendido
    $productoMasVendidoId = array_keys($productoVendidos, max($productoVendidos))[0];
    $productoMasVendido = array_filter($productos, fn($p) => $p['id'] === $productoMasVendidoId);
    $productoMasVendido = array_values($productoMasVendido)[0] ?? null;

    // Cliente que más ha comprado
    $clienteMasCompradorId = array_keys($clienteCompras, max($clienteCompras))[0];
    $clienteMasComprador = array_filter($clientes, fn($c) => $c['id'] === $clienteMasCompradorId);
    $clienteMasComprador = array_values($clienteMasComprador)[0] ?? null;

    // Generar informe
    echo"</br>---------------------------------------------------------------------------------------------------------------";
    echo "</br>\nInforme de ventas:\n";
    echo "</br>Total de ventas: \$$totalVentas\n";
    echo "</br>Producto más vendido: {$productoMasVendido['nombre']} (ID: {$productoMasVendido['id']}, Cantidad: {$productoVendidos[$productoMasVendidoId]})\n";
    echo "</br>Cliente que más ha comprado: {$clienteMasComprador['nombre']} (ID: {$clienteMasComprador['id']}, Compras: {$clienteCompras[$clienteMasCompradorId]})\n";
}

// 10. Generar el resumen de ventas
resumenVentas($ventas, $tiendaData['productos'], $tiendaData['clientes']);

// 11. Convertir el arreglo actualizado de vuelta a JSON
echo"</br>---------------------------------------------------------------------------------------------------------------";
$jsonActualizado = json_encode($tiendaData, JSON_PRETTY_PRINT);
echo "</br></br>\nDatos actualizados de la tienda (JSON):\n$jsonActualizado\n";