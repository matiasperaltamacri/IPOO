<?php
class Funcion{
    private $nombre;
    private $inicio;
    private $duracion;
    private $precio;
    public function __construct($nombre,$inicio,$duracion,$precio)
    {
        $this->nombre=$nombre;
        $this->inicio=$inicio;
        $this->duracion=$duracion;
        $this->precio=$precio;
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
    // Retorna un String con la hora en un formato hh:mm
    public function tiempo($time){
        $minutos=$time%100;
        $horas=($time-$minutos)/100;
        if ($horas<10){
            if ($minutos<10){
                $horario="0".$horas.":0".$minutos;
            }
            else{
                $horario="0".$horas.":".$minutos;
            }
        }
        else{
            if ($minutos<10){
                $horario=$horas.":0".$minutos;
            }
            else{
                $horario=$horas.":".$minutos;
            }
        }
        return $horario;
    }
    
    public function __toString()
    {
        return "Nombre: ".$this->getNombre()."\nInicio: ".$this->tiempo($this->getInicio())."\nDuracion: ".$this->tiempo($this->getDuracion())."\nPrecio: ".$this->getPrecio()."\n";
    }
}