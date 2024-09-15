<?php
// Empresa.php
require_once 'Empleado.php';
require_once 'evaluo.php';

class Empresa {
    private $empleados = [];

    public function agregarEmpleado(Empleado $empleado) {
        $this->empleados[] = $empleado;
    }

    public function listarEmpleados() {
        foreach ($this->empleados as $empleado) {
            echo "Nombre: " . $empleado->getNombre() . ", ID: " . $empleado->getId_empleado() . ", Salario: " . $empleado->getSalario_base() . "<br>";
        }
    }

    public function calcularNominaTotal() {
        $total = 0;
        foreach ($this->empleados as $empleado) {
            $total += $empleado->getSalario_base();
        }
        return $total;
    }

    public function realizarEvaluaciones() {
        foreach ($this->empleados as $empleado) {
            if ($empleado instanceof Evaluable) {
                echo "Evaluación del empleado " . $empleado->getNombre() . ": " . $empleado->evaluarDesempenio() . "<br>";
            } else {
                echo "El empleado " . $empleado->getNombre() . " no es evaluable.<br>";
            }
        }
    }
}
?>