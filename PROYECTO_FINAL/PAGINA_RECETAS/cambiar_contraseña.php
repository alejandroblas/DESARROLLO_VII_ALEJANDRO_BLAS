<?php
session_start();
include('db.php');  // Incluir la conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);

    // Validar que el campo no esté vacío
    if (empty($email)) {
        $_SESSION['error_message'] = "El correo electrónico es requerido.";
        header("Location: cambiar_contraseña.php");
        exit();
    }

    // Validar formato del correo electrónico
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error_message'] = "Correo electrónico inválido.";
        header("Location: cambiar_contraseña.php");
        exit();
    }

    // Verificar si el correo existe en la base de datos
    $sql = "SELECT id, email FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        $_SESSION['error_message'] = "El correo electrónico no está registrado.";
        header("Location: cambiar_contraseña.php");
        exit();
    }

    // Generar un token único para el restablecimiento de la contraseña
    $token = bin2hex(random_bytes(50));  // Generar un token de 100 caracteres
    $expires = date("U") + 3600;  // Expiración del token dentro de 1 hora

    // Guardar el token en la base de datos
    $sql = "INSERT INTO password_resets (email, token, expires) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sss', $email, $token, $expires);
    $stmt->execute();

    // Enviar el correo electrónico con el enlace de restablecimiento
    $reset_link = "http://yourdomain.com/restablecer_contraseña.php?token=" . $token;
    $subject = "Restablecimiento de contraseña";
    $message = "Haz clic en el siguiente enlace para restablecer tu contraseña:\n" . $reset_link;
    $headers = "From: no-reply@yourdomain.com";

    if (mail($email, $subject, $message, $headers)) {
        $_SESSION['success_message'] = "Se ha enviado un enlace para restablecer tu contraseña.";
        header("Location: social.php");  // Redirigir al inicio de sesión
    } else {
        $_SESSION['error_message'] = "Hubo un error al enviar el correo. Inténtalo nuevamente.";
        header("Location: cambiar_contraseña.php");
    }
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer Contraseña</title>
</head>
<body>

    <h1>Restablecer contraseña</h1>
    <form action="cambiar_contraseña.php" method="POST">
        <input type="email" name="email" placeholder="Correo electrónico" required>
        <button type="submit">Enviar enlace de restablecimiento</button>
    </form>

    <?php
    // Mostrar mensaje de error si existe
    if (isset($_SESSION['error_message'])) {
        echo "<p class='error'>{$_SESSION['error_message']}</p>";
        unset($_SESSION['error_message']);
    }

    // Mostrar mensaje de éxito si existe
    if (isset($_SESSION['success_message'])) {
        echo "<p class='success'>{$_SESSION['success_message']}</p>";
        unset($_SESSION['success_message']);
    }
    ?>

</body>
</html>