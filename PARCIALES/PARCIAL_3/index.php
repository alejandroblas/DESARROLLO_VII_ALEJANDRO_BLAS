
<?php
session_start();

// Array de usuarios predefinidos
$usuarios = [
    'usuario1' => 'contraseña1',
    'usuario2' => 'contraseña2',
];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validar credenciales
    if (isset($usuarios[$username]) && $usuarios[$username] === $password) {
        $_SESSION['username'] = $username;
        header('Location: dashboard.php');
        exit();
    } else {
        $error = "Credenciales inválidas.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Inicio de Sesión</title>
    <link rel="stylesheet" href="style.css">
    
</head>
<body>
    <h2>Iniciar Sesión</h2>
    <form method="POST">
        <input type="text" name="username" placeholder="Usuario" required>
        <input type="password" name="password" placeholder="Contraseña" required>
        <button type="submit">Iniciar Sesión</button>
    </form>
    <?php if (isset($error)) echo "<p>$error</p>"; ?>
</body>
</html>
