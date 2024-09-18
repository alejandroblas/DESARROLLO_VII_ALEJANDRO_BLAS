<?php
// Empresa.php
require_once 'empleado.php';
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
            if ($empleado instanceof evaluo) {
                echo "Evaluación del empleado " . $empleado->getNombre() . ": " . $empleado->evaluarDesempenio() . "<br>";
            } else {
                echo "El empleado " . $empleado->getNombre() . " no es evaluable.<br>";
            }
        }
    }

    public function aumentarSalarios() {
        foreach ($this->empleados as $empleado) {
            if ($empleado instanceof evaluo) {
                // Calcular el nuevo salario basado en la evaluación
                $evaluacion = $empleado->evaluarDesempenio();
                $aumento = ($evaluacion - $empleado->getSalario_base()) * 0.1; // 10% del incremento en evaluación
                $nuevoSalario = $empleado->getSalario_base() + $aumento;
                $empleado->setSalario_base($nuevoSalario);
                echo "Nuevo salario de " . $empleado->getNombre() . ": " . $nuevoSalario . "<br>";
            }
        }
    }

    public function listarEmpleadosPorDepartamento() {
        $departamentos = [];
        foreach ($this->empleados as $empleado) {
            if ($empleado instanceof Gerente) {
                $departamento = $empleado->getDepartamento();
                if (!isset($departamentos[$departamento])) {
                    $departamentos[$departamento] = [];
                }
                $departamentos[$departamento][] = $empleado;
            }
        }

        foreach ($departamentos as $departamento => $empleados) {
            echo "<h3>Departamento: $departav  mento</h3>";
            foreach ($empleados as $empleado) {
                echo "Nombre: " . $empleado->getNombre() . ", ID: " . $empleado->getId_empleado() . ", Salario: " . $empleado->getSalario_base() . "<br>";
            }
        }
    }

    public function calcularSalarioPromedioPorTipo() {
        $salarios = [
            'Gerente' => [],
            'Desarrollador' => []
        ];

        foreach ($this->empleados as $empleado) {
            if ($empleado instanceof Gerente) {
                $salarios['Gerente'][] = $empleado->getSalario_base();
            } elseif ($empleado instanceof Desarrollador) {
                $salarios['Desarrollador'][] = $empleado->getSalario_base();
            }
        }

        foreach ($salarios as $tipo => $salariosTipo) {
            if (count($salariosTipo) > 0) {
                $promedio = array_sum($salariosTipo) / count($salariosTipo);
                echo "Salario promedio de $tipo: " . $promedio . "<br>";
            }
        }
    }

    public function guardarEmpleados($archivo) {
        $datos = [];
        foreach ($this->empleados as $empleado) {
            $datos[] = [
                'nombre' => $empleado->getNombre(),
                'idEmpleado' => $empleado->getId_empleado(),
                'salarioBase' => $empleado->getSalario_base(),
                'tipo' => get_class($empleado)
            ];
        }
        file_put_contents($archivo, json_encode($datos));
    }

    public function cargarEmpleados($archivo) {
        if (file_exists($archivo)) {
            $datos = json_decode(file_get_contents($archivo), true);
            foreach ($datos as $dato) {
                $tipo = $dato['tipo'];
                $empleado = new $tipo($dato['nombre'], $dato['idEmpleado'], $dato['salarioBase']);
                $this->agregarEmpleado($empleado);
            }
        }
    }
}
?>