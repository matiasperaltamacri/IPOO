<?php
include_once "Actividad.php";
class ActCine extends Actividad {
    private $genero;
    private $pais;
    private $mensajeoperacion;
    public function __construct()
    {
        parent::__construct();
        $this->genero="";
        $this->pais="";
    }
    public function cargar($array){
        parent::cargar($array);
        $this->setGenero($array["genero"]);
        $this->setPais($array["pais"]);
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
    public function setmensajeoperacion($mensajeoperacion){
		$this->mensajeoperacion=$mensajeoperacion;
	}
    public function getmensajeoperacion(){
		return $this->mensajeoperacion ;
	}
    public function __toString()
    {
        $cadena=parent::__toString();
        return $cadena."Genero de la pelicula: ".$this->getGenero()."\nPais de origen: ".$this->getPais()."\n";
    }
    public function darCosto(){
        $costo=parent::darCosto();
        $costo+=$costo*0.65;
        return $costo;
    }


    
    public function insertar(){
		$base=new BaseDatos();
		$resp= false;
        if (parent::insertar()){
            $consultaInsertar="insert INTO actcine (idActividad,genero,pais) 
                        VALUES (".parent::getIdActividad().", '".$this->getGenero()."','".$this->getPais()."')";		
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
        }	
		return $resp;
	}



    public function modificar(){
	    $resp =false; 
	    $base=new BaseDatos();
        if (parent::modificar()){
            $consultaModifica="UPDATE actcine SET genero='".$this->getGenero()."',pais='".$this->getPais()."' WHERE idActividad=".$this->getIdActividad();
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



    public function Buscar($id){
		$base=new BaseDatos();
		$consulta="Select * from actcine where idActividad=".$id;
		$resp= false;
		if($base->Iniciar()){
		    if($base->Ejecutar($consulta)){
				if($row2=$base->Registro()){
				    parent::Buscar($id);
				    $this->setGenero($row2['genero']);
                    $this->setPais($row2['pais']);
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
				$consultaBorra="DELETE FROM actcine WHERE idActividad=".parent::getIdActividad();
                //echo $consultaBorra."\n";
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
		$consulta="Select * from actcine ";
		if ($condicion!=""){
		    $consulta=$consulta.' where '.$condicion;
		}
		$consulta.=" order by idActividad ";
        //echo $consulta." consulta\n";
		if($base->Iniciar()){
		    if($base->Ejecutar($consulta)){				
			    $arreglo= array();
				while($row2=$base->Registro()){
					$obj=new ActCine();
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
    
}