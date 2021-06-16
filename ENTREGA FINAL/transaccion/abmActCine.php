<?php
class abmActCine{
    /*
        Recibe los parametros para setear el nuevo objeto y los inserta en la base. 
        Retorna un booleano con true si tuvo exito.
    */
    public function ingresarActividad($array){
        $objActCine=new ActCine();
        $objActCine->cargar($array);
        $resp=$objActCine->insertar();
        return $resp;
    }
    /* 
        Recibe como parametros el objeto que se quiere cambiar y una variable $mod con el atributo a cambiar.
        Setea el nuevo valor y lo cambia en la base. 
        Retorna un booleano con true si tuvo exito.
    */
    public function modificar($objAct,$mod){
        if (($mod["atributo"])=="nombre"){
            $objAct->setNombre($mod["valor"]);
        }
        elseif (($mod["atributo"])=="precio"){
            $objAct->setPrecio($mod["valor"]);
        }
        elseif (($mod["atributo"])=="inicio"){
            $objAct->setInicio($mod["valor"]);
        }
        elseif (($mod["atributo"])=="duracion"){
            $objAct->setDuracion($mod["valor"]);
        }
        elseif (($mod["atributo"])=="fecha"){
            $objAct->setFecha($mod["valor"]);
        }
        elseif (($mod["atributo"])=="pais"){
            $objAct->setPais($mod["valor"]);
        }
        elseif (($mod["atributo"])=="genero"){
            $objAct->setGenero($mod["valor"]);
        }
        $resp=$objAct->modificar();
        return $resp;
    }
    /*
        Recibe como parametro el id del objeto que se desea recuperar de la base y se invoca a la funcion buscar para setear en el objeto los datos recuperados.
        Retorna el objeto.
    */
    public function seleccionActividad($idActividad){
        $objAct=new ActCine();
        $objAct->buscar($idActividad);
        return $objAct;
    }
    /*
        Recibe como parametro una id con la cual se llama a eliminar (de la base) la actividad y su padre.
        Retorna un booleano con true si tuvo exito.
    */
    public function eliminarActividad($idActividad){
        $objAct=new ActCine();
        $objAct->setIdActividad($idActividad);
        $resp=$objAct->eliminar();
        return $resp;
    }
}    
?>