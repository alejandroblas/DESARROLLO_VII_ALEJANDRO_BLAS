<?php
include 'utilidades_texto.php';
$frases = ["hola php","adios php","iniciando en php"];
for($i=0;$i<=2;$i++){
echo "<br><br>Frase". $i+1
echo "<br>Tamaño: " . contar_palabras($frases[$i]) . " palabras.<br>";
echo "Vocales: " . contar_vocales($frases[$i]);
echo "<br>Inverción de la frase: " . invertir_palabras($frases[$i]);
}
?>