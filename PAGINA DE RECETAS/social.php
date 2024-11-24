<?php
session_start();  // Iniciar sesión
include('db.php');  // Incluir la conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Validar que los campos no estén vacíos
    if (empty($email) || empty($password)) {
        $_SESSION['error_message'] = "Todos los campos son requeridos.";
        header("Location: social.php");
        exit();
    }

    // Validar formato del correo
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error_message'] = "Correo electrónico inválido.";
        header("Location: social.php");
        exit();
    }

    // Verificar si el correo está registrado
    $sql = "SELECT id, email, password FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verificar si el correo existe en la base de datos
    if ($result->num_rows == 0) {
        $_SESSION['error_message'] = "El correo electrónico no está registrado.";
        header("Location: social.php");
        exit();
    }

    // Verificar la contraseña
    $user = $result->fetch_assoc();
    if (!password_verify($password, $user['password'])) {
        $_SESSION['error_message'] = "Contraseña incorrecta. ¿Olvidaste tu contraseña?";
        $_SESSION['email_for_password_reset'] = $email;  // Guardar el email para resetear
        header("Location: social.php");
        exit();
    }

    // Si las credenciales son correctas, iniciar sesión y guardar la información del usuario
    $_SESSION['user_id'] = $user['id'];  // Guardar el ID del usuario en la sesión
    $_SESSION['user_email'] = $email;  // Guardar el correo del usuario en la sesión

    // Redirigir a la página de recetas
    header("Location: recetas.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>

    <div class="form-container">
        <h1>Iniciar sesión</h1>
        <form action="social.php" method="POST">
            <input type="email" name="email" placeholder="Correo electrónico" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <button type="submit" class="btn">Iniciar sesión</button>

            <?php
            // Mostrar mensaje de error si existe
            if (isset($_SESSION['error_message'])) {
                echo "<p class='error'>{$_SESSION['error_message']}</p>";
                unset($_SESSION['error_message']);
            }
            ?>
        </form>

        <a href="registrer.php" class="link">¿No tienes cuenta? Regístrate</a>

       
    </div>

</body>
</html>