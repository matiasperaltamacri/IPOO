<?php

use ActTeatro as GlobalActTeatro;

include_once "Actividad.php";
class ActTeatro extends Actividad{
    private $mensajeoperacion;
    public function __construct()
    {
        parent::__construct();
    }
    public function cargar($array){
        parent::cargar($array);
    }
    public function setmensajeoperacion($mensajeoperacion){
		$this->mensajeoperacion=$mensajeoperacion;
	}
    public function getmensajeoperacion(){
		return $this->mensajeoperacion ;
	}
    public function darCosto(){
        $costo=parent::darCosto();
        $costo+=$costo*0.45;
        return $costo;
    }



    public function insertar(){
		$base=new BaseDatos();
		$resp= false;
        if (parent::insertar()){
            $consultaInsertar="insert INTO actteatro (idActividad) 
                        VALUES (".parent::getIdActividad().")";
            if($base->Iniciar()){
                if($base->Ejecutar($consultaInsertar)){
                    $resp=  true;
                }else {
                    $this->setmensajeoperacion($base->getError());
                }
            } else {
                $this->setmensajeoperacion($base->getError());	
            }
        }    
		return $resp;
    }



    public function eliminar(){
		$base=new BaseDatos();
		$resp=false;
		if($base->Iniciar()){
				$consultaBorra="DELETE FROM actteatro WHERE idActividad=".parent::getIdActividad();
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
    /*

    */
    public function listar($condicion=""){
	    $arreglo = null;
		$base=new BaseDatos();
		$consulta="Select * from actteatro ";
		if ($condicion!=""){
		    $consulta=$consulta.' where '.$condicion;
		}
		$consulta.=" order by idActividad ";
		if($base->Iniciar()){
		    if($base->Ejecutar($consulta)){				
			    $arreglo= array();
				while($row2=$base->Registro()){
					$obj=new ActTeatro();
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
		$consulta="Select * from actteatro where idActividad=".$idActividad;
		$resp= false;
		if($base->Iniciar()){
		    if($base->Ejecutar($consulta)){
				if($row2=$base->Registro()){	
				    parent::Buscar($idActividad);
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
        if (parent::modificar()){
			$resp=true;            
        }
		return $resp;
	}
} 