<?php
session_start();

// Incluir archivo de configuración de la base de datos
include('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener y sanitizar los datos del formulario
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Validar que los datos sean correctos
    if (empty($username) || empty($email) || empty($password)) {
        $_SESSION['error_message'] = "Todos los campos son requeridos.";
        header("Location: register.php");
        exit();
    }

    // Validar formato del correo
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error_message'] = "Correo electrónico inválido.";
        header("Location: register.php");
        exit();
    }

    // Validar que la contraseña tenga al menos 6 caracteres
    if (strlen($password) < 6) {
        $_SESSION['error_message'] = "La contraseña debe tener al menos 6 caracteres.";
        header("Location: register.php");
        exit();
    }

    // Comprobar si el correo electrónico ya está registrado
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['error_message'] = "El correo electrónico ya está registrado.";
        header("Location: registrer.php");
        exit();
    }

    // Comprobar si el nombre de usuario ya existe
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['error_message'] = "El nombre de usuario ya está registrado.";
        header("Location: register.php");
        exit();
    }

    // Si todo es correcto, hash de la contraseña y guardar en la base de datos
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sss', $username, $email, $hashed_password);

    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Registro exitoso. <a href='social.php'>Iniciar sesión</a>";
        header("Location: registrer.php");
        exit();
    } else {
        $_SESSION['error_message'] = "Error al registrar usuario.";
        header("Location: registrer.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>

    <div class="form-container">
        <h1>Registrar cuenta</h1>

        <!-- Mostrar mensajes de error o éxito -->
        <?php if (isset($_SESSION['error_message'])): ?>
            <p class="error"><?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?></p>
        <?php endif; ?>
        <?php if (isset($_SESSION['success_message'])): ?>
            <p class="success"><?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?></p>
        <?php endif; ?>

        <!-- Formulario de registro -->
        <form method="POST" action="registrer.php">
            <input type="text" name="username" placeholder="Nombre de usuario" required>
            <input type="email" name="email" placeholder="Correo electrónico" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <button type="submit">Registrar</button>
        </form>

        <a href="social.php" class="link">¿Ya tienes cuenta? Iniciar sesión</a>
    </div>

</body>
</html>