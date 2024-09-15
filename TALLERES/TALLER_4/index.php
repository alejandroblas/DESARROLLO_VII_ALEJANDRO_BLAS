<?php
// index.php
require_once 'Empleado.php';
require_once 'Gerente.php';
require_once 'Desarrollador.php';
require_once 'Empresa.php';


// Crear instancias de empleados
$gerente1 = new Gerente("Juan Pérez", "G001", 5000, "Ventas");
$desarrollador1 = new Desarrollador("Ana Gómez", "D001", 3000, "PHP", 5);

// Asignar bono al gerente
$gerente1->asignarBono(1000);

// Crear instancia de la empresa
$empresa = new Empresa();

// Agregar empleados a la empresa
$empresa->agregarEmpleado($gerente1);
$empresa->agregarEmpleado($desarrollador1);

// Listar empleados
echo "<h2>Listado de Empleados:</h2>";
$empresa->listarEmpleados();

// Calcular y mostrar nómina total
echo "<h2>Nómina Total:</h2>";
echo $empresa->calcularNominaTotal() . "<br>";

// Realizar evaluaciones de desempeño
echo "<h2>Evaluaciones de Desempeño:</h2>";
$empresa->realizarEvaluaciones();
?>