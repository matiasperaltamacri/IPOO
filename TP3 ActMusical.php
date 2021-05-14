<?php
include_once "TP3 Actividad.php";
class ActMusical extends Actividad {
    private $director;
    private $cantActores;
    private $incremento;
    public function __construct($nombre,$inicio,$duracion,$precio,$fecha,$director,$actores)
    {
        parent::__construct($nombre,$inicio,$duracion,$precio,$fecha);
        $this->director=$director;
        $this->cantActores=$actores;
        $this->incremento=12;
    }
    public function setDirector($director){
        $this->director=$director;
    }
    public function getDirector(){
        return $this->director;
    }
    public function setCantActores($actores){
        $this->cantActores=$actores;
    }
    public function getCantActores(){
        return $this->cantActores;
    }
    public function setIncremento($inc){
        $this->incremento=$inc;
    }
    public function getIncremento(){
        return $this->incremento;
    }
    public function __toString()
    {
        $cadena=parent::__toString();
        return $cadena."Director: ".$this->getDirector()."\nCantidad de personas: ".$this->getCantActores()."\n";
    }
}