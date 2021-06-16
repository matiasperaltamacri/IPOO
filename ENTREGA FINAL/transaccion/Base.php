<?php
class BaseDatos{
    private $HOSTNAME;
    private $BASEDATOS;
    private $USUARIO;
    private $CLAVE;
    private $CONEXION;
    private $QUERY;
    private $RESULT;
    private $ERROR;

    public function __construct(){
        $this->HOSTNAME = "127.0.0.1";
        $this->BASEDATOS = "bdteatro";
        $this->USUARIO = "root";
        $this->CLAVE="";
        $this->RESULT=0;
        $this->QUERY="";
        $this->ERROR="";
    }
    public function getError(){
        return "\n".$this->ERROR;        
    }
    public  function Iniciar(){
        $resp  = false;
        $conexion = mysqli_connect($this->HOSTNAME,$this->USUARIO,$this->CLAVE,$this->BASEDATOS);
        if ($conexion){            
            if (mysqli_select_db($conexion,$this->BASEDATOS)){
                $this->CONEXION = $conexion;
                unset($this->QUERY);
                unset($this->ERROR);
                $resp = true;
            }  else {
                $this->ERROR = mysqli_errno($conexion) . ": " .mysqli_error($conexion);
            }
        }else{
            
            $this->ERROR =  mysqli_errno($conexion) . ": " .mysqli_error($conexion);
        }
        return $resp;
    }
    public function Ejecutar($consulta){
        $resp  = false;
        unset($this->ERROR);
        $this->QUERY = $consulta;
        if(  $this->RESULT = mysqli_query( $this->CONEXION,$consulta)){
            $resp = true;
        } else {
            $this->ERROR =mysqli_errno( $this->CONEXION).": ". mysqli_error( $this->CONEXION);
        }
        return $resp;
    }
    public function devuelveIDInsercion($consulta){
        $resp = null;
        unset($this->ERROR);
        $this->QUERY = $consulta;
        if ($this->RESULT = mysqli_query($this->CONEXION,$consulta)){
            $id = mysqli_insert_id($this->CONEXION);
            $resp =  $id;
        } else {
            $this->ERROR =mysqli_errno( $this->CONEXION) . ": " . mysqli_error( $this->CONEXION);           
        }
    return $resp;
    }
    public function Registro() {
        $resp = null;
        if ($this->RESULT){
            unset($this->ERROR);
            if($temp = mysqli_fetch_assoc($this->RESULT)){
                $resp = $temp;
            }else{
                mysqli_free_result($this->RESULT);
            }
        }else{
            $this->ERROR = mysqli_errno($this->CONEXION) . ": " . mysqli_error($this->CONEXION);
        }
        return $resp ;
    }

    // Verifica la conexion con la base de datos y genera las tablas de actividad y teatro
    public function crearTeatro(){
        if($this->Iniciar()){
            $tablaTeatro= "create TABLE IF NOT EXISTS teatro ( 
                idTeatro INT(10) NOT NULL AUTO_INCREMENT,
                nombre VARCHAR(20) NOT NULL, 
                direccion VARCHAR(30) NOT NULL, 
                PRIMARY KEY (idTeatro)
                )";
            
            if ($this->Ejecutar($tablaTeatro)){ //Genera tabla 'teatro'
                $tablaAct= "CREATe TABLE IF NOT EXISTS actividad (
                    idActividad INT(10) NOT NULL AUTO_INCREMENT,
                    nombre VARCHAR(20) NOT NULL,
                    inicio VARCHAR(10)NOT NULL,
                    duracion INT(10)NOT NULL,
                    precio FLOAT(10)NOT NULL,
                    fecha VARCHAR(15) NOT NULL,
                    idTeatro INT(10) NOT NULL,
                    PRIMARY KEY (idActividad),
                    FOREIGN KEY (idTeatro) REFERENCES teatro (idTeatro) )";
                if($this->Ejecutar($tablaAct)){ //Genera tabla 'actividad'
                    $tablaActMusical= "CREATe TABLE IF NOT EXISTS actMusical (
                        idActividad INT(10) NOT NULL,
                        director VARCHAR (20) NOT NULL, 
                        actores INT(10) NOT NULL, 
                        PRIMARY KEY (idActividad),
                        FOREIGN KEY (idActividad) REFERENCES actividad (idActividad) )";
                    $this->Ejecutar($tablaActMusical); //Genera tabla 'actMusical'
                    $tablaActCine= "CREATe TABLE IF NOT EXISTS actCine (
                        idActividad INT(10) NOT NULL,
                        genero VARCHAR (20) NOT NULL, 
                        pais VARCHAR (20) NOT NULL,
                        PRIMARY KEY (idActividad),
                        FOREIGN KEY (idActividad) REFERENCES actividad (idActividad) )";
                    $this->Ejecutar($tablaActCine); //Genera tabla 'actCine'
                    $tablaActTeatro= "CREATe TABLE IF NOT EXISTS actTeatro (
                        idActividad INT(10) NOT NULL,
                        PRIMARY KEY (idActividad),
                        FOREIGN KEY (idActividad) REFERENCES actividad (idActividad) )";
                    $this->Ejecutar($tablaActTeatro); //Genera tabla 'actTeatro'
                }
            } 
        }   
    }
}
