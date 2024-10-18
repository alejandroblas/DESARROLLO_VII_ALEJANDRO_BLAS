<?php

function validarNombre($nombre) {
    return !empty($nombre) && strlen($nombre) <= 50;
}

function validarEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

function validarEdad($edad) {
    return is_numeric($edad) && $edad >= 18 && $edad <= 120;
}

function calcularEdad($fechaNacimiento) {
    $fecha = DateTime::createFromFormat('Y-m-d', $fechaNacimiento);
    if ($fecha) {
        $hoy = new DateTime();
        return $hoy->diff($fecha)->y;
    }
    return false;
}

function validarFechaNacimiento($fechaNacimiento) {
    $fecha = DateTime::createFromFormat('Y-m-d', $fechaNacimiento);
    return $fecha && $fecha->format('Y-m-d') === $fechaNacimiento;
}

function validarSitio_Web($sitio_Web) {
    return empty($sitio_Web) || filter_var($sitio_Web, FILTER_VALIDATE_URL) !== false;
}

function validarGenero($genero) {
    $generosValidos = ['masculino', 'femenino', 'otro'];
    return in_array($genero, $generosValidos);
}

function validarIntereses($intereses) {
    $interesesValidos = ['deportes', 'musica', 'lectura'];
    return !empty($intereses) && count(array_intersect($intereses, $interesesValidos)) === count($intereses);
}

function validarComentarios($comentarios) {
    return strlen($comentarios) <= 500;
}

function validarFotoPerfil($archivo) {
    $tiposPermitidos = ['image/jpeg', 'image/png', 'image/gif'];
    $tamanoMaximo = 1 * 1024 * 1024; // 1MB

    if ($archivo['error'] !== UPLOAD_ERR_OK) {
        return false;
    }

    if (!in_array($archivo['type'], $tiposPermitidos)) {
        return false;
    }

    if ($archivo['size'] > $tamanoMaximo) {
        return false;
    }

    return true;
}

?>