<?php
class abmTeatro{
    /* 
        Recibe como parametros el objeto que se quiere cambiar y una variable $mod con el atributo a cambiar.
        Setea el nuevo valor y lo cambia en la base. 
        Retorna un booleano con true si tuvo exito.
    */
    public function modificarTeatro($objTeatro,$mod){
        if ($mod["nombre"]<>null){
            $objTeatro->setNombre($mod["nombre"]);
        }
        else{
            $objTeatro->setDireccion($mod["direccion"]);
        }
        $resp=$objTeatro->modificar();
        return $resp;
    }
    /*
        Recibe como parametro el id del objTeatro que se desea recuperar de la base.
        Retorna dicho objeto.
    */
    public function seleccionTeatro($idTeatro){
        $objTeatro=new Teatro();
        $objTeatro->buscar($idTeatro,true);
        return $objTeatro;
    }
    /*
        Recibe los parametros para setear el nuevo objeto Teatro y los inserta en la base. 
        Retorna un booleano con true si tuvo exito.
    */
    public function ingresarTeatro($nombre,$direccion){
        $objTeatro=new Teatro();
        $objTeatro->setNombre($nombre);
        $objTeatro->setDireccion($direccion);
        $resp=$objTeatro->insertar();
        return $resp;
    }
    /*
        Recibe como parametro un objetoTeatro y se llama a eliminar (de la base) cada una de las funciones en la coleccion.
        Si se tuvo exito en eliminar las funciones se procede a llamar la funcion eliminar del teatro.
        Retorna un booleano con true si tuvo exito.
    */
    public function eliminarTeatro($objTeatro){
        $colAct= $objTeatro->getActividades();
        $i=0;
        $resp=true;
        while ($resp && ($i<count($colAct))){
            $resp= $colAct[$i]->eliminar();
            $i++;
        }
        if ($resp){
            $resp=$objTeatro->eliminar();
        }
        return $resp;
    }
}

?>