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
    // Cambia el nombre del teatro
    public function otroNombre($nombre){
        $this->nombre=$nombre;
    }
    // Cambia la direccion del teatro
    public function otraDireccion($direccion){
        $this->direccion=$direccion;
    }
    // Recibe como parametros el número de funcion y el nuevo nombre que se le asigna a la misma
    public function otraFuncion($num,$funcion){
        $nueva=$this->getFunciones();
        $nueva[$num]["nombre"]=$funcion;
        $this->setFunciones($nueva);
    }
    // Recibe como parametros el número de funcion y el nuevo precio que se le asigna a la misma
    public function otroPrecio($num,$precio){
        $nueva=$this->getFunciones();
        $nueva[$num]["precio"]=$precio;
        $this->setFunciones($nueva);
    }
    public function __toString()
    {
        return "TEATRO: ".$this->getNombre()."\nDirección: ".$this->getDirec()."\nFUNCION 1\n".$this->getFunciones()[1]["nombre"]." $".$this->getFunciones()[1]["precio"]."\nFUNCION 2\n".$this->getFunciones()[2]["nombre"]." $".$this->getFunciones()[2]["precio"]."\nFUNCION 3\n".$this->getFunciones()[3]["nombre"]." $".$this->getFunciones()[3]["precio"]."\nFUNCION 4\n".$this->getFunciones()[4]["nombre"]." $".$this->getFunciones()[4]["precio"]."\n";
    }

}