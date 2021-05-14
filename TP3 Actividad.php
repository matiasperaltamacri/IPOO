<?php
class Actividad{
    private $nombre;
    private $inicio;
    private $duracion;
    private $precio;
    private $fecha;
    public function __construct($nombre,$inicio,$duracion,$precio,$fecha)
    {
        $this->nombre=$nombre;
        $this->inicio=$inicio;
        $this->duracion=$duracion;
        $this->precio=$precio;
        $this->fecha=$fecha;
    }
    public function setNombre($nombre){
        $this->nombre=$nombre;
    }
    public function getNombre(){
        return $this->nombre;
    }
    public function setInicio($inicio){
        $this->inicio=$inicio;
    }
    public function getInicio(){
        return $this->inicio;
    }
    public function setDuracion($duracion){
        $this->duracion=$duracion;
    }
    public function getDuracion(){
        return $this->duracion;
    }
    public function setPrecio($precio){
        $this->precio=$precio;
    }
    public function getPrecio(){
        return $this->precio;
    }
    public function setFecha($fecha){
        $this->fecha=$fecha;
    }
    public function getFecha(){
        return $this->fecha;
    }
    public function __toString()
    {
        $hora=$this->getInicio()["hora"];
        $minutos=$this->getInicio()["minutos"];
        return "Nombre: ".$this->getNombre()."\nPrecio: ".$this->getPrecio()."\nInicio: ".$hora.":".$minutos."\nDuracion: ".$this->getDuracion()." minutos\nFecha: ".$this->getFecha()["dia"]."/".$this->getFecha()["mes"]."/".$this->getFecha()["año"]."\n";
    }
}