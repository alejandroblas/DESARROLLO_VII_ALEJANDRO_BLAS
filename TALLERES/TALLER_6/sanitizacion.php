<?php
function sanitizarNombre($nombre) {
    return htmlspecialchars(trim($nombre), ENT_QUOTES, 'UTF-8');
}

function sanitizarEmail($email) {
    return filter_var(trim($email), FILTER_SANITIZE_EMAIL);
}

function sanitizarEdad($edad) {
    return filter_var($edad, FILTER_SANITIZE_NUMBER_INT);
}

function sanitizarFechaNacimiento($fechaNacimiento) {
    $fecha = DateTime::createFromFormat('Y-m-d', $fechaNacimiento);
    if ($fecha !== false) {
        return $fecha->format('Y-m-d');
    } else {
        return null; // Asegúrate de gestionar este caso donde se retorna null
    }
}

function sanitizarSitio_Web($sitio_Web) {
    return filter_var(trim($sitio_Web), FILTER_SANITIZE_URL);
}

function sanitizarGenero($genero) {
    return htmlspecialchars(trim($genero), ENT_QUOTES, 'UTF-8');
}

function sanitizarIntereses($intereses) {
    if (!is_array($intereses)) {
        return []; // Retornar un array vacío si no es un array
    }
    return array_map(function($interes) {
        return htmlspecialchars(trim($interes), ENT_QUOTES, 'UTF-8');
    }, $intereses);
}

function sanitizarComentarios($comentarios) {
    return htmlspecialchars(trim($comentarios), ENT_QUOTES, 'UTF-8');
}
?>