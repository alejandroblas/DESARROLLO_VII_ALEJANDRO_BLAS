<?php
// Configuración básica
$googleClientId = '';
$googleRedirectUri = '';
$googleAuthUrl = '';
$scope = 'openid email profile';

// Crear la URL de autorización
$authUrl = $googleAuthUrl . '?response_type=code&client_id=' . $googleClientId . '&redirect_uri=' . urlencode($googleRedirectUri) . '&scope=' . $scope;

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login con Google</title>
    <!-- Vincular el archivo CSS externo -->
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="login-container">
        <h1>Inicia sesión con Google</h1>
        <a href="<?php echo $authUrl; ?>">
            <button>Iniciar sesión con Google</button>
        </a>
    </div>
</body>
</html>