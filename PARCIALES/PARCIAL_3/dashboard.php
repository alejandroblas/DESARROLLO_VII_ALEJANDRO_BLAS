<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

// Inicializar tareas
if (!isset($_SESSION['tasks'])) {
    $_SESSION['tasks'] = [];
}

// Agregar tarea
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $due_date = $_POST['due_date'];

    // Validar datos
    if (!empty($title) && !empty($description) && !empty($due_date) && strtotime($due_date) > time()) {
        $_SESSION['tasks'][] = ['title' => $title, 'description' => $description, 'due_date' => $due_date];
    } else {
        $error = "Por favor completa todos los campos y asegúrate de que la fecha sea válida y futura.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <style>
        table {
            width: 50%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>Bienvenido, <?php echo $_SESSION['username']; ?>!</h2>
    <form method="POST">
        <input type="text" name="title" placeholder="Título de la tarea" required><br></br>
        <textarea name="description" placeholder="Descripción de la tarea" required></textarea><br></br>
        <input type="date" name="due_date" required>
        <button type="submit">Agregar Tarea</button>
    </form>
    <?php if (isset($error)) echo "<p>$error</p>"; ?>

    <h3>Lista de Tareas</h3>
<table>
    <thead>
        <tr>
            <th>Título</th>
            <th>Descripción</th>
            <th>Fecha Límite</th>
        </tr>
    </thead>
    <body>
        <?php foreach ($_SESSION['tasks'] as $task): ?>
            <tr>
                <td><?php echo htmlspecialchars($task['title']); ?></td>
                <td><?php echo htmlspecialchars($task['description']); ?></td>
                <td><?php echo htmlspecialchars($task['due_date']); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

    <a href="logout.php">Cerrar Sesión</a>
</body>
</html>

