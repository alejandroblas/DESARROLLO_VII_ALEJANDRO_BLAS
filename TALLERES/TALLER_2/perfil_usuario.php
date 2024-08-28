<?php
$nombre_completo ="Alejandro blas"
$edad "29"
$correo "blas1294@gmail.com"
$telefono "68293432"
// Definición de constante
define("OCUPACION", "Estudiante");

// Imprimir información utilizando diferentes métodos de concatenación e impresión
echo "<p>Nombre Completo: " . $nombre_completo . "</p>";
echo "<p>Edad: " . $edad . "</p>";
echo "<p>Correo Electrónico: " . $correo . "</p>";
echo "<p>Teléfono: " . $telefono . "</p>";
echo "<p>Ocupación: " . OCUPACION . "</p>";

// Imprimir tipo y valor de cada variable y constante usando var_dump
echo "<p><strong>Información de las variables y constante:</strong></p>";
echo "<p>";
var_dump($nombre_completo);
echo "</p>";
echo "<p>";
var_dump($edad);
echo "</p>";
echo "<p>";
var_dump($correo);
echo "</p>";
echo "<p>";
var_dump($telefono);
echo "</p>";
echo "<p>";
var_dump(OCUPACION);
echo "</p>";


?>