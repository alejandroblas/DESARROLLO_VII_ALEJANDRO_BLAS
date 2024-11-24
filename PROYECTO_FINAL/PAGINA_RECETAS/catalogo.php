<?php
include('db.php');
$sql = "SELECT * FROM recipes ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recetas Disponibles</title>
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

        h1 {
            margin: 0;
            font-size: 36px;
        }

        .container {
            max-width: 1000px;
            margin: 30px auto;
            padding: 20px;
            background-color: white;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .recipe-list {
            list-style-type: none;
            padding: 0;
        }

        .recipe-list li {
            background-color: #fff;
            margin: 10px 0;
            padding: 15px;
            border-radius: 6px;
            border: 1px solid #ddd;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s;
        }

        .recipe-list li:hover {
            background-color: #f1f1f1;
        }

        .recipe-list a {
            text-decoration: none;
            font-size: 18px;
            color: #333;
            font-weight: bold;
            display: block;
            transition: color 0.3s;
        }

        .recipe-list a:hover {
            color: #4CAF50;
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
<a href="social.php?logout=1" style="position: fixed; top: 10px; right: 10px; background-color: #f00; color: white; padding: 10px; border-radius: 5px; text-decoration: none; font-weight: bold;">
  Cerrar sesión
</a>
    <header>
        <h1>Recetas Disponibles</h1>
        

    </header>

    <div class="container">
        <ul class="recipe-list">
            <?php while ($recipe = $result->fetch_assoc()) { ?>
                <li>
                    <a href="misrecetas.php?id=<?= $recipe['id'] ?>">
                        <?= htmlspecialchars($recipe['title']) ?>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </div>

    <footer class="footer">
        <p>&copy; 2024 Mis Recetas - Todos los derechos reservados</p>
    </footer>

</body>
</html>