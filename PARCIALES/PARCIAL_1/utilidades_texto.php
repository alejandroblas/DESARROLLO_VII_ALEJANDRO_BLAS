<?php
$texto= "hola php";
echo "Tamaño de la palabra HOLA PHP: " . contar_palabras($texto) . " palabras.<br>";
echo "Vocales de la palabra HOLA PHP: " . contar_vocales($texto);
echo "<br>Invertir la palabra HOLA PHP: " . invertir_palabras($texto);

function contar_palabras($texto){
    return $cant = strlen($texto);
}

function contar_vocales($texto){
    $cant = strlen($texto);
    $vocal=0;
    for($i=$cant; $i>=1;$i--){
        $letra=substr($texto, $i, 1);
        if($letra=="a" || $letra=="e" || $letra=="i"||$letra=="o"||$letra=="u"){
            $vocal++;
        }
    }
    return $vocal;
}

function invertir_palabras($texto){
    $cant = strlen($texto);
    $nueva="";
    for($i=$cant; $i>=0;$i--){
        $nueva = $nueva . substr($texto, $i, 1);
    }
    return $nueva;
}

?>