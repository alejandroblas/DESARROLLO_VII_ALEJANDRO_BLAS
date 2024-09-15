<?php
require_once 'Empleado.php';
require_once 'evaluo.php';

class Desarrollador extends Empleado {
    private $tipo_lenguaje;
    private $nivelExperiencia;

    public function __construct($nombre, $ID_empleado, $Salario_base, $tipo_lenguaje, $nivelExperiencia) {
        parent::__construct($nombre, $ID_empleado, $Salario_base);
        $this->tipo_lenguaje = $tipo_lenguaje;
        $this->nivelExperiencia = $nivelExperiencia;
    }

    // Getters y Setters
    public function getLenguajeProgramacion() {
        return $this->lenguajeProgramacion;
    }

    public function setLenguajeProgramacion($tipo_lenguaje) {
        $this->tipo_lenguaje = $tipo_lenguaje;
    }

    public function getNivelExperiencia() {
        return $this->nivelExperiencia;
    }

    public function setNivelExperiencia($nivelExperiencia) {
        $this->nivelExperiencia = $nivelExperiencia;
    }

    // Implementación del método de la interfaz Evaluable
    public function evaluarDesempenio() {
        // Ejemplo simple: Incremento del salario base por nivel de experiencia
        $factorExperiencia = $this->nivelExperiencia * 100;
        return $this->salarioBase + $factorExperiencia;
    }
}
?>

    
