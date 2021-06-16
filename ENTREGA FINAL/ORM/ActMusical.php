<?php

use ActMusical as GlobalActMusical;

include_once "Actividad.php";
class ActMusical extends Actividad {
    private $director;
    private $cantActores;
    private $mensajeoperacion;
    public function __construct()
    {
        parent::__construct();
        $this->director="";
        $this->cantActores="";
    }
    public function cargar($array){
        parent::cargar($array);
        $this->setDirector($array["director"]);
        $this->setCantActores($array["actores"]);
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
    public function __toString()
    {
        $cadena=parent::__toString();
        return $cadena."Director: ".$this->getDirector()."\nCantidad de personas: ".$this->getCantActores()."\n";
    }
    public function setmensajeoperacion($mensajeoperacion){
		$this->mensajeoperacion=$mensajeoperacion;
	}
    public function getmensajeoperacion(){
		return $this->mensajeoperacion ;
	}
    public function darCosto(){
        $costo=parent::darCosto();
        $costo+=$costo*0.12;
        return $costo;
    }



    public function insertar(){
		$base=new BaseDatos();
		$resp= false;
        if (parent::insertar()){
            $consultaInsertar="insert INTO actmusical (idActividad,director,actores) 
                        VALUES (".parent::getIdActividad().", '".$this->getDirector()."','".$this->getCantActores()."')";		
            //echo $consultaInsertar."\n";
            if($base->Iniciar()){
                if($base->Ejecutar($consultaInsertar)){
                    $resp=  true;
                }	else {
                    $this->setmensajeoperacion($base->getError());
                }
            } else {
                    $this->setmensajeoperacion($base->getError());	
            }
            return $resp;
        }		
	}



    public function eliminar(){
		$base=new BaseDatos();
		$resp=false;
		if($base->Iniciar()){
				$consultaBorra="DELETE FROM actmusical WHERE idActividad=".parent::getIdActividad();                
				if($base->Ejecutar($consultaBorra)){
				    if(parent::eliminar()){
				        $resp=  true;
				    }
				}else{
						$this->setmensajeoperacion($base->getError());
					
				}
		}else{
				$this->setmensajeoperacion($base->getError());
			
		}
		return $resp; 
	}



    public function listar($condicion=""){
	    $arreglo = null;
		$base=new BaseDatos();
		$consulta="Select * from actmusical ";
		if ($condicion!=""){
		    $consulta=$consulta.' where '.$condicion;
		}
		$consulta.=" order by idActividad ";
		if($base->Iniciar()){
		    if($base->Ejecutar($consulta)){				
			    $arreglo= array();
				while($row2=$base->Registro()){
					$obj=new ActMusical();
					$obj->Buscar($row2['idActividad']);
					array_push($arreglo,$obj);
				}
		 	}	else {
		 			$this->setmensajeoperacion($base->getError());
			}
		 }	else {
		 		$this->setmensajeoperacion($base->getError());
		 }	
		 return $arreglo;
	}	

    /*
    */
    public function Buscar($idActividad){
		$base=new BaseDatos();
		$consulta="Select * from actmusical where idActividad=".$idActividad;
		$resp= false;
		if($base->Iniciar()){
		    if($base->Ejecutar($consulta)){
				if($row2=$base->Registro()){	
				    parent::Buscar($idActividad);
				    $this->setCantActores($row2['actores']);
                    $this->setDirector($row2['director']);
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


	public function modificar(){
	    $resp =false; 
	    $base=new BaseDatos();
        if (parent::modificar()){
            $consultaModifica="UPDATE actmusical SET director='".$this->getDirector()."',actores='".$this->getCantActores()."' WHERE idActividad=".$this->getIdActividad();
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
		
	}
}