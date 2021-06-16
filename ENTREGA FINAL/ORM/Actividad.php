<?php
class Actividad{
    private $nombre;
    private $inicio;
    private $duracion;
    private $precio;
    private $fecha;
    private $ObjTeatro;
    private $idActividad;
    private $mensajeoperacion;
    public function __construct()
    {
        $this->nombre="";
        $this->inicio="";
        $this->duracion="";
        $this->precio="";
        $this->fecha=""; 
        $this->idTeatro=0;
        $this->idActividad=0;
    }
    public function cargar($array){
        $this->setIdActividad($array["idActividad"]);
        $this->setNombre($array["nombre"]);
        $this->setInicio($array["inicio"]);
        $this->setDuracion($array["duracion"]);
        $this->setPrecio($array["precio"]);
        $this->setFecha($array["fecha"]);
        $this->setObjTeatro($array["objTeatro"]);
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
    public function getObjTeatro()
    {
        return $this->ObjTeatro;
    }
    public function setObjTeatro($ObjTeatro)
    {
        $this->ObjTeatro = $ObjTeatro;
    }
    public function getIdActividad()
    {
        return $this->idActividad;
    }
    public function setIdActividad($idActividad)
    {
        $this->idActividad = $idActividad;
    }
    public function setmensajeoperacion($mensajeoperacion){
		$this->mensajeoperacion=$mensajeoperacion;
	}
    public function getmensajeoperacion(){
		return $this->mensajeoperacion ;
	}
    public function __toString()
    {
        //$hora=$this->getInicio()["hora"];
        //$minutos=$this->getInicio()["minutos"];
        return "Nombre: ".$this->getNombre()."\nID ".$this->getIdActividad()."\nPrecio: ".$this->getPrecio()."\nInicio: ".$this->getInicio()."\nDuracion: ".$this->getDuracion()." minutos\nFecha: ".$this->getFecha()."\n";
    }
    public function darCosto(){
        $costo=$this->getPrecio();
        return $costo;
    }
    
    /*
    */
    public function insertar(){
		$base=new BaseDatos();
		$resp= false;
        $inicio=$this->getInicio()["hora"].":".$this->getInicio()["minutos"];
        $fecha=$this->getFecha()["dia"]."/".$this->getFecha()["mes"]."/".$this->getFecha()["año"];
		$consultaInsertar="insert INTO actividad (idTeatro,nombre, precio, inicio, duracion, fecha) 
                        VALUES (".$this->getObjTeatro()->getId().",'".$this->getNombre()."', ".$this->getPrecio().",'".$inicio."',".$this->getDuracion().",'".$fecha."')";		
		if($base->Iniciar()){
			if($id=$base->devuelveIDInsercion($consultaInsertar)){
                $this->setIdActividad($id);
			    $resp=  true;
			}	else {
					$this->setmensajeoperacion($base->getError());	
			}
		} else {
				$this->setmensajeoperacion($base->getError());	
		}
		return $resp;
	}



    public function listar($condicion=""){
	    $arregloActividad = null;
		$base=new BaseDatos();
		$consultaActividades="Select * from actividad ";
		if ($condicion!=""){
		    $consultaActividades=$consultaActividades.' where '.$condicion;
		}        
        //echo $consultaActividades."\n";
		if($base->Iniciar()){   
			if($base->Ejecutar($consultaActividades)){	
				$arregloActividad= array();
				while($row2=$base->Registro()){
				    $idAct=$row2['idActividad'];
                    $idTeatro=$row2['idTeatro'];                    
                    $objTeatro=new Teatro();
                    $objTeatro->Buscar($idTeatro,false);
					$actividad=new Actividad();
                    $actividad->Buscar($idAct);
					array_push($arregloActividad,$actividad);	
				}		
		 	}	else {
		 			$this->setmensajeoperacion($base->getError());		 		
			}
		 }	else {
		 		$this->setmensajeoperacion($base->getError());		 	
		 }	
		 return $arregloActividad;
	}	



    public function modificar(){
	    $resp =false; 
	    $base=new BaseDatos();
		$consultaModifica="UPDATE actividad SET nombre='".$this->getNombre()."',precio='".$this->getPrecio()."',inicio='".$this->getInicio()."',duracion='".$this->getDuracion()."',fecha='".$this->getFecha()."' WHERE idActividad=".$this->getIdActividad();
		if($base->Iniciar()){
			if($base->Ejecutar($consultaModifica)){
			    $resp=  true;
			}else{
				$this->setmensajeoperacion($base->getError());				
			}
		}else{
				$this->setmensajeoperacion($base->getError());			
		}
		return $resp;
	}

    /**
	 * Recupera los datos de una actividad por id
	 * @param int $dni
	 * @return true en caso de encontrar los datos, false en caso contrario 
	 */		
    public function Buscar($id){
		$base=new BaseDatos();
		$consultaPersona="Select * from actividad where idActividad=".$id;
		$resp= false;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaPersona)){
				if($row2=$base->Registro()){
				    $this->setIdActividad($row2['idActividad']);
					$this->setNombre($row2['nombre']);
					$this->setPrecio($row2['precio']);
                    $this->setInicio($row2['inicio']);
                    $this->setDuracion($row2['duracion']);
                    $this->setFecha($row2['fecha']);
                    $idTeatro=($row2['idTeatro']);
                    $objTeatro=new Teatro();
                    $objTeatro->Buscar($idTeatro,false);
                    $this->setObjTeatro($objTeatro);
					$resp= true;
				}							
		 	}	else {
		 			$this->setmensajeoperacion($base->getError());		 		
			}
		 }	else {
		 		$this->setmensajeoperacion($base->getError());		 	
		 }		
		 return $resp;
	}



    public function eliminar(){
		$base=new BaseDatos();
		$resp=false;
		if($base->Iniciar()){
				$consultaBorra="DELETE FROM actividad WHERE idActividad=".$this->getIdActividad();
                //echo $consultaBorra." elimina Actividad\n";
				if($base->Ejecutar($consultaBorra)){
				    $resp=  true;
				}else{
						$this->setmensajeoperacion($base->getError());					
				}
		}else{
				$this->setmensajeoperacion($base->getError());			
		}
		return $resp; 
	}

    
}