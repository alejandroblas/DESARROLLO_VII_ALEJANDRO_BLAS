<?php

ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', 1);

session_start();
// Configuración de cookies
function setUserCookie($username) {
    setcookie('username', htmlspecialchars($username), time() + 86400, "/"); // 24 horas
}
?>