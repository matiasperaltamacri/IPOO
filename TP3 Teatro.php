<?php
class Teatro{
    private $nombre;
    private $direccion;
    private $colActividades;
    public function __construct($nombre,$dir,$act)
    {
        $this->nombre=$nombre;
        $this->direccion=$dir;
        $this->colActividades=$act;
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
    public function getDireccion(){
        return $this->direccion;
    }
    public function setActividades($act){
        $this->colActividades=$act;
    }
    public function getActividades(){
        return $this->colActividades;
    }
    //Agrega una nueva actividad a la coleccion
    public function agregarActividad($nuevaAct){
        $colActividades=$this->getActividades();
        array_push($colActividades,$nuevaAct);
        $this->setActividades($colActividades);
    }
    // Metodo que cambia el nombre del teatro
    public function cambiarNombre($nuevoNombre){
        $this->setNombre($nuevoNombre);
    }
    // Metodo que cambia la direccion del teatro
    public function cambiarDireccion($nuevaDir){
        $this->setDireccion($nuevaDir);
    }
    // Cambia el nombre de una actividad
    public function cambiarNombreActividad($actividad,$nuevoNombre){
        $colActividades=$this->getActividades();
        for ($i=0;$i<(count($colActividades));$i++){
            $nombre=$colActividades[$i]->getNombre();
            if ($nombre==$actividad){
                $colActividades[$i]->setNombre($nuevoNombre);
                $this->setActividades($colActividades);
            }
        }
    }
    // Cambia el precio de una actividad
    public function cambiarPrecioActividad($act,$nuevoPrecio){
        $colActividades=$this->getActividades();
        for ($i=0;$i<(count($colActividades));$i++){
            $nombre=$colActividades[$i]->getNombre();
            if ($nombre==$act){
                $colActividades[$i]->setPrecio($nuevoPrecio);
                $this->setActividades($colActividades);
            }
        }
    }
    //Controla los horarios de las actividades del teatro
    public function controlHorarios(){
        $colActividades=$this->getActividades();
        $cadena=""; //variable que retorna el metodo
        $verifica=true; //verifica si no se encontro un choque de horarios
        for ($i=0;$i<(count($colActividades));$i++){
            $inicio=$colActividades[$i]->getInicio();
            $duracion=$colActividades[$i]->getDuracion();
            $inicioF1=((($inicio["hora"])*60)+($inicio["minutos"]));    //Cambio el formato para modificarlo mas facilmente
            $finF1=$inicioF1+$duracion;
            $diaF1=$colActividades[$i]->getFecha()["dia"];
            $mesF1=$colActividades[$i]->getFecha()["mes"];
            $anioF1=$colActividades[$i]->getFecha()["año"];
            for ($j=0;$j<(count($colActividades));$j++){  //Comparo una actividad con el resto de la coleccion
                if (!($i==$j)){   //Para no comparar la actividad con si misma
                    $diaF2=$colActividades[$j]->getFecha()["dia"];
                    $mesF2=$colActividades[$j]->getFecha()["mes"];
                    $anioF2=$colActividades[$j]->getFecha()["año"];
                    if ($diaF1==$diaF2 && $mesF1==$mesF2 && $anioF1==$anioF2){// Para ver si las actividades transcurren en el mismo día
                        $inicio=$colActividades[$j]->getInicio();
                        $duracion=$colActividades[$j]->getDuracion();
                        $inicioF2=((($inicio["hora"])*60)+($inicio["minutos"]));
                        $finF2=$inicioF2+$duracion;
                        if ((($inicioF2>=$inicioF1)&&($inicioF2<$finF1))||(($finF2>$inicioF1)&&($finF2<$finF1))){
                            $nombreF1=$colActividades[$i]->getNombre();
                            $nombreF2=$colActividades[$j]->getNombre();
                            $cadena=$cadena."El horario de la actividad ".$nombreF1." y de la actividad ".$nombreF2." se solapan entre sí\n"; 
                            $verifica=false;
                        }
                    }
                    
                }
            }
        }
        if ($verifica){
            $cadena="No hay horarios de actividades que se solapen entre sí.\n";
        }
        return $cadena;
    }
    public function darCostos($mes){
        $colActividades=$this->getActividades();
        $costo=0;
        for ($i=0;$i<(count($colActividades));$i++){
            $mesAct=$colActividades[$i]->getFecha()["mes"];
            if ($mes==$mesAct){
                $precio=$colActividades[$i]->getPrecio();
                $incremento=$colActividades[$i]->getIncremento();
                $costo+=$precio+($precio*($incremento/100));
            }
        }
        return $costo;
    }
    public function __toString()
    {
        $colActividades=$this->getActividades();
        $cadena="";
        for ($i=0;$i<(count($colActividades));$i++){
            $cadena=$cadena."------xxxxxx------\nActividad ".($i+1)."\n".$colActividades[$i];
        }
        return "Teatro ".$this->getNombre()."\nDirección: ".$this->getDireccion()."\n".$cadena;
    }
}