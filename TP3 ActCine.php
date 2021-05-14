<?php
include_once "TP3 Actividad.php";
class ActCine extends Actividad {
    private $genero;
    private $pais;
    private $incremento;
    public function __construct($nombre,$inicio,$duracion,$precio,$fecha,$genero,$pais)
    {
        parent::__construct($nombre,$inicio,$duracion,$precio,$fecha);
        $this->genero=$genero;
        $this->pais=$pais;
        $this->incremento=65;
    }
    public function setGenero($genero){
        $this->genero=$genero;
    }
    public function getGenero(){
        return $this->genero;
    }
    public function setPais($pais){
        $this->pais=$pais;
    }
    public function getPais(){
        return $this->pais;
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
        return $cadena."Genero de la pelicula: ".$this->getGenero()."\nPais de origen: ".$this->getPais()."\n";
    }
}