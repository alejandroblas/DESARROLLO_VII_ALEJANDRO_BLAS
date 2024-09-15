<?php

class Empleado {
    public $Nombre;
    public $ID_empleado;
    public $Salario_base;


    public function __construct($Nombre, $ID_empleado, $Salario_base) {
        $this->setNombre($Nombre);
        $this->setID_empleado($ID_empleado);
        $this->setSalario_base($Salario_base);
    }

    public function getNombre() {
            return $this->Nombre;
    }
    
     public function setNombre($Nombre) {
            $this->Nombre = trim($Nombre);
    }
    
    public function getID_empleado() {
            return $this->ID_empleado;
    }
    
    public function setID_empleado($ID_empleado) {
            $this->ID_empleado = trim($ID_empleado);
    }
    
    public function getSalario_base() {
            return $this->Salario_base;
    }
    
    public function setSalario_base($Salario_base) {
            $this->Salario_base = intval($Salario_base);
       
    }


}
?>