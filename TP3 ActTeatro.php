<?php
class ActTeatro extends Actividad{
    private $incremento;
    public function __construct($nombre,$inicio,$precio,$duracion,$fecha)
    {
        parent::__construct($nombre,$inicio,$duracion,$precio,$fecha);
        $this->incremento=45;
    }
    public function setIncremento($inc){
        $this->incremento=$inc;
    }
    public function getIncremento(){
        return $this->incremento;
    }
} 