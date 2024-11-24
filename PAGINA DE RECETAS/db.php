<?php
// Configuración de la conexión a la base de datos
$host = 'localhost';  // Cambia esto si tu servidor de base de datos no está en localhost
$dbname = 'recetas_web';  // Nombre de la base de datos que creamos anteriormente
$username = 'root';  // Usuario de la base de datos (ajusta según tu configuración)
$password = '';  // Contraseña de la base de datos (ajusta según tu configuración)

// Crear una conexión a la base de datos
$conn = new mysqli($host, $username, $password, $dbname);

// Verificar si la conexión fue exitosa
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Iniciar la sesión si no está iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>