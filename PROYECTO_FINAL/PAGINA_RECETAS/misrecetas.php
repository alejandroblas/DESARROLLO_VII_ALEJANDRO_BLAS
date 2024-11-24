<?php
// Incluir archivo de conexión a la base de datos
include('db.php');

// Verificar si el parámetro 'id' está presente en la URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];  // Obtener el ID de la receta desde la URL

    // Preparar la consulta SQL para obtener la receta con el ID especificado
    $sql = "SELECT * FROM recipes WHERE id = ?";

    // Preparar la sentencia SQL usando la conexión de base de datos
    if ($stmt = $conn->prepare($sql)) {
        // Vincular el parámetro 'id' a la consulta
        $stmt->bind_param("i", $id);

        // Ejecutar la consulta
        $stmt->execute();

        // Obtener el resultado de la consulta
        $result = $stmt->get_result();

        // Verificar si se encontró la receta
        if ($result->num_rows > 0) {
            // Obtener los datos de la receta
            $recipe = $result->fetch_assoc();
        } else {
            echo "Receta no encontrada.";
        }

        // Cerrar la sentencia
        $stmt->close();
    } else {
        echo "Error en la consulta.";
    }
} else {
    echo "ID no proporcionado.";
}

// Cerrar la conexión a la base de datos
$conn->close();
?>
<a href="social.php?logout=1" style="position: fixed; top: 10px; right: 10px; background-color: #f00; color: white; padding: 10px; border-radius: 5px; text-decoration: none; font-weight: bold;">
  Cerrar sesión
</a>
<!DOCTYPE html>
<html lang="es">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles de la Receta</title>
  
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            color: #333;
        }

        header {
            background-color: #4CAF50;
            color: white;
            padding: 20px;
            text-align: center;
        }

        .container {
            max-width: 1000px;
            margin: 30px auto;
            padding: 20px;
            background-color: white;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .recipe-details {
            margin-bottom: 20px;
        }

        .recipe-details h2 {
            color: #4CAF50;
        }

        .recipe-details p {
            font-size: 18px;
        }

        .image-container img {
            max-width: 100%;
            height: auto;
            margin-top: 20px;
        }

        .footer {
            text-align: center;
            padding: 20px;
            background-color: #333;
            color: white;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>

    <header>
        <h1>Detalles de la Receta</h1>
        
<!-- Enlace para cerrar sesión -->

    </header>

    <div class="container">
        <?php if (isset($recipe)) { ?>
            <div class="recipe-details">
                <h2><?= htmlspecialchars($recipe['title']) ?></h2>
                <p><strong>Descripción:</strong> <?= nl2br(htmlspecialchars($recipe['description'])) ?></p><!--nbl2br es salto de linea-->
                <p><strong>Ingredientes:</strong> <?= nl2br(htmlspecialchars($recipe['ingredients'])) ?></p>
                <p><strong>Instrucciones:</strong> <?= nl2br(htmlspecialchars($recipe['steps'])) ?></p>
                <p><strong>Fecha de creación:</strong> <?= htmlspecialchars($recipe['created_at']) ?></p>
            </div>

            <?php if ($recipe['recipe_image']) { ?>
                <div class="image-container">
                    <h3>Imagen de la receta:</h3>
                    <img src="data:image/jpeg;base64,<?= base64_encode($recipe['recipe_image']) ?>" alt="Imagen de la receta"><!--Utiliza un formato llamado "Data URI", 
                    que permite incluir la imagen directamente en el código HTML como una cadena de texto en formato base64. -->
                </div>
            <?php } ?>

        <?php } else { ?>
            <p>No se encontró la receta.</p>
        <?php } ?>
    </div>

    <footer class="footer">
        <p>&copy; 2024 Mis Recetas - Todos los derechos reservados</p>
    </footer>

</body>
</html>