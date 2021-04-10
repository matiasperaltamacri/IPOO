<?php
class Teatro{
    private $nombre;
    private $direccion;
    private $funciones;
    public function __construct($nombre,$dir,$func)
    {
        $this->nombre=$nombre;
        $this->direccion=$dir;
        $this->funciones=$func;
    }
    public function setNombre($nombre){
        $this->nombre=$nombre;
    }
    public function getNombre(){
        return $this->nombre;
    }
    public function setDireccion($direccion){
        $this->direccion=$direccion;
    }
    public function getDirec(){
        return $this->direccion;
    }
    public function setFunciones($funciones){
        $this->funciones=$funciones;
    }
    public function getFunciones(){
        return $this->funciones;
    }
    // Recibe como parametros la posicion de la funcion y el nuevo nombre que se le asigna a la misma
    public function otraFuncion($posicion,$funcion){
        $coleccion=$this->getFunciones();
        $coleccion[$posicion]->setNombre($funcion);
    }
    // Recibe como parametros la posicion de la funcion y el nuevo precio que se le asigna a la misma
    public function otroPrecio($posicion,$precio){
        $coleccion=$this->getFunciones();
        $coleccion[$posicion]->setPrecio($precio);
    }
    public function __toString()
    {
        $totalFunciones=count($this->getFunciones());
        $verFunciones="";
        for ($i=0;$i<$totalFunciones;$i++){
            $verFunciones=$verFunciones."\nFUNCION ".($i+1)."\n".$this->getFunciones()[$i]."\n";
        }
        return "\nTEATRO: ".$this->getNombre()."\nDirección: ".$this->getDirec()."\n".$verFunciones."\n";
    }

}