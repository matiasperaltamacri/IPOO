<?php
class Teatro{
    private $nombre;
    private $direccion;
    private $colActividades;
    private $id;
    private $mensajeoperacion;
    public function __construct()
    {
        $this->nombre="";
        $this->direccion="";
        $this->colActividades="";
        $this->id=0;
    }
    public function cargar($array){
        $this->setId($array["id"]);
        $this->setDireccion($array["direccion"]);
        $this->setNombre($array["nombre"]);
        $this->setActividades($array["colAct"]);
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
    public function setmensajeoperacion($mensajeoperacion){
		$this->mensajeoperacion=$mensajeoperacion;
	}
    public function getmensajeoperacion(){
		return $this->mensajeoperacion ;
	}
    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
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
    public function controlHorarios($horaF1,$minF1,$duracionF1,$diaF1,$mesF1,$anioF1){
        $colActividades=$this->getActividades();
        $verifica=true; //verifica si no se encontro un choque de horarios
        $inicioF1=($horaF1*60)+$minF1; //Cambio el formato para modificarlo mas facilmente
        $finF1=$inicioF1+$duracionF1;
        for ($j=0;$j<(count($colActividades));$j++){  //Comparo una actividad con el resto de la coleccion
            $fecha2=$colActividades[$j]->getFecha();
            $diaF2=intval(substr($fecha2,0,2));
            $mesF2=intval(substr($fecha2,3,2));
            $anioF2=intval(substr($fecha2,6,4));
            if ($diaF1==$diaF2 && $mesF1==$mesF2 && $anioF1==$anioF2){// Para ver si las actividades transcurren en el mismo día
                $inicio=$colActividades[$j]->getInicio();
                $hora=intval(substr($inicio,0,2));
                $minutos=intval(substr($inicio,3,2));
                $duracion=$colActividades[$j]->getDuracion();
                $inicioF2=(($hora*60)+$minutos);
                $finF2=$inicioF2+$duracion;
                if ((($inicioF2>=$inicioF1)&&($inicioF2<$finF1))||(($finF2>$inicioF1)&&($finF2<$finF1))){
                    $verifica=false;                        
                }                    
            }            
        }
        return $verifica;
    }
    public function darCostos($mes){
        $colActividades=$this->getActividades();
        $costo=0;
        for ($i=0;$i<(count($colActividades));$i++){
            $fecha=$colActividades[$i]->getFecha();
            $mesAct=intval(substr($fecha,3,2));
            if ($mes==$mesAct){
                $costo+=$colActividades[$i]->darCosto();
            }
        }
        return $costo;
    }
    public function __toString()
    {
        $colActividades=$this->getActividades();
        $cadena="";
        for ($i=0;$i<(count($colActividades));$i++){
            $cadena=$cadena."------ACTIVIDAD------\nActividad ".($i+1)."\n".$colActividades[$i];
        }
        return "Teatro ".$this->getNombre()."\nID ".$this->getId()."\nDirección: ".$this->getDireccion()."\n".$cadena;
    }



    public function insertar(){
		$base=new BaseDatos();
		$resp= false;
		$consultaInsertar="insert INTO teatro (nombre, direccion) 
                        VALUES ('".$this->getNombre()."', '".$this->getDireccion()."')";		
		if($base->Iniciar()){
			if($id=$base->devuelveIDInsercion($consultaInsertar)){
                $this->setId($id);
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
	    $arregloTeatro = null;
		$base=new BaseDatos();
		$consultaTeatros="Select * from teatro ";
		if ($condicion!=""){
		    $consultaTeatros=$consultaTeatros.' where '.$condicion;
		}        
		if($base->Iniciar()){           
			if($base->Ejecutar($consultaTeatros)){	
				$arregloTeatro= array();
				while($row2=$base->Registro()){
				    $id=$row2['idTeatro'];
					$nombre=$row2['nombre'];
					$direccion=$row2['direccion'];				
					$teatro=new Teatro();
					$teatro->cargar(["id"=>$id,"nombre"=>$nombre,"direccion"=>$direccion,"colAct"=>null]);
					array_push($arregloTeatro,$teatro);	
				}		
		 	}	else {
		 			$this->setmensajeoperacion($base->getError());		 		
			}
		 }	else {
		 		$this->setmensajeoperacion($base->getError());		 	
		 }	
		 return $arregloTeatro;
	}	

    

    public function modificar(){
	    $resp =false; 
	    $base=new BaseDatos();
		$consultaModifica="UPDATE teatro SET nombre='".$this->getNombre()."',direccion='".$this->getDireccion()."' WHERE idTeatro=".$this->getId();
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
	 * Recupera los datos de una persona por dni
	 * @param int $dni
	 * @return true en caso de encontrar los datos, false en caso contrario 
	 */		
    public function Buscar($id,$ejecutar){
		$base=new BaseDatos();
		$consultaPersona="Select * from teatro where idTeatro=".$id;
		$resp= false;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaPersona)){
				if($row2=$base->Registro()){
				    $this->setId($row2['idTeatro']);
					$this->setNombre($row2['nombre']);
					$this->setDireccion($row2['direccion']);
                    $coleccion=[];
                    if ($ejecutar){// Para no entrar en un loop
                        $condicion="idTeatro=".$id;
                        $objActividad=new Actividad();
                        $colActividades=$objActividad->listar($condicion);//Obtiene las actividades con el idTeatro
                        //print_r($colActividades);                    
                        $objActCine=new ActCine();
                        $objActTeatro=new ActTeatro();
                        $objActMusical=new ActMusical();
                        for ($i=0; $i<(count($colActividades));$i++){   //Recorre todos los id de la coleccion y busca las especializaciones que tienen el id como clave foranea
                            $idAct=$colActividades[$i]->getIdActividad();
                            $condicion="idActividad=".$idAct;
                            if (($obj=$objActCine->listar($condicion))<>[]){ //Para no guardar arreglos vacios
                                array_push($coleccion,$obj[0]); //Es un arreglo con un solo objeto
                            }   
                            if (($obj=$objActTeatro->listar($condicion))<>[]){
                                array_push($coleccion,$obj[0]);
                            }   
                            if (($obj=$objActMusical->listar($condicion))<>[]){
                                array_push($coleccion,$obj[0]);
                            }               
                        }       
                    }                    
                    $this->setActividades($coleccion);
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
    /*
        ELIMINAR TEATRO
    */
    public function eliminar(){
		$base=new BaseDatos();
		$resp=false;
		if($base->Iniciar()){
				$consultaBorra="DELETE FROM teatro WHERE idTeatro=".$this->getId();
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