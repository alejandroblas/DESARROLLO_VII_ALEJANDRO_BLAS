<?php
// Iniciar la sesión
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['user_email'])) {
    header("Location: social.php");
    exit();
}

$user_email = $_SESSION['user_email']; // El correo del usuario
// Incluir archivo de configuración de la base de datos
include('db.php');

// Verificar si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del formulario
    $title = $_POST['title'];
    $description = $_POST['description'];
    $ingredients = $_POST['ingredients'];
    $steps = $_POST['steps'];
    $prep_time = $_POST['prep_time'];

    // Verificar si se ha subido una imagen
    $recipe_image = null;
    if (isset($_FILES['recipe_image']) && $_FILES['recipe_image']['error'] == 0) {
        // Leer el archivo de imagen
        $fileTmpPath = $_FILES['recipe_image']['tmp_name'];
        $fileData = file_get_contents($fileTmpPath); // Obtener el contenido del archivo

        // Verificar si el archivo es una imagen
        $check = getimagesize($fileTmpPath);
        if ($check !== false) {
            $recipe_image = $fileData; // Guardar el contenido binario del archivo
        } else {
            echo "El archivo no es una imagen.";
            exit;
        }
    } else {
        // Si no se sube una imagen, puedes manejarlo como quieras (por ejemplo, asignar NULL o una imagen por defecto)
        echo "No se subió ninguna imagen.";
        exit;
    }

    // Preparar la consulta SQL para insertar la receta
    $sql = "INSERT INTO recipes (title, description, ingredients, steps, prep_time, recipe_image) 
            VALUES (?, ?, ?, ?, ?, ?)";

    // Usar prepared statements para evitar SQL Injection
    if ($stmt = $conn->prepare($sql)) {
        // Bind los parámetros (el campo de la imagen se manejará como BLOB)
        $stmt->bind_param("ssssis", $title, $description, $ingredients, $steps, $prep_time, $recipe_image);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            echo "Receta añadida correctamente.";
        } else {
            echo "Error al añadir receta: " . $stmt->error;
        }

        // Cerrar la sentencia
        $stmt->close();
    } else {
        echo "Error de preparación de la consulta: " . $conn->error;
    }
}

// Verificar si el usuario quiere cerrar sesión
if (isset($_GET['logout']) && $_GET['logout'] == 1) {
    // Destruir la sesión
    session_unset();
    session_destroy();
    
    // Redirigir al inicio de sesión o página principal
    header("Location: social.php");
    exit();
}
?>

<!-- Formulario HTML -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Recetas</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
<button type="button" onclick="window.location.href='catalogo.php';">Ver mis recetas</button>

<a href="social.php?logout=1" style="position: fixed; top: 10px; right: 10px; background-color: #f00; color: white; padding: 10px; border-radius: 5px; text-decoration: none; font-weight: bold;">
  Cerrar sesión
</a>

<div class="container">
    <h1>Agregar Receta</h1>
    
    <!-- Mostrar correo del usuario -->
    <p>Correo del usuario: <?php echo htmlspecialchars($user_email); ?></p>
    <form method="POST" action="recetas.php" enctype="multipart/form-data">
    <input type="text" name="title" placeholder="Título de la receta" required>
    <textarea name="description" placeholder="Descripción" required></textarea>
    <textarea name="ingredients" placeholder="Ingredientes" required></textarea>
    <textarea name="steps" placeholder="Pasos" required></textarea>
    <input type="number" name="prep_time" placeholder="Tiempo de preparación" required>
    
    <!-- Campo para seleccionar una imagen -->
    <input type="file" name="recipe_image" accept="image/*" required>
    
    <button type="submit">Añadir receta</button>
</form>
</div>

</body>
</html>