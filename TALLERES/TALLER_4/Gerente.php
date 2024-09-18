<?php
require_once 'Empleado.php';
require_once 'evaluo.php';

class Gerente extends Empleado implements evaluo{
    private $departamentos;
    private $bono;

    public function __construct($nombre, $ID_empleado, $Salario_base, $departamentos) {
        parent::__construct($nombre, $ID_empleado, $Salario_base);
        $this->departamento = $departamentos;
        $this->bono = 0;
    }

    // Getters y Setters
    public function getDepartamento() {
        return $this->departamentos;
    }

    public function setDepartamento($departamentos) {
        $this->departamentos = $departamentos;
    }

    public function getBono() {
        return $this->bono;
    }

    public function setBono($bono) {
        $this->bono = $bono;
    }

    // Método para asignar bonos
    public function asignarBono($monto) {
        $this->bono = $monto;
    }

    // Implementación del método de la interfaz Evaluable
    public function evaluarDesempenio() {
        // Ejemplo simple: Bono del 10% del salario base
        return $this->Salario_base * 0.10 + $this->bono;
    }
}
?>

