<?php
include_once "ORM/Teatro.php";
include_once "ORM/ActMusical.php";
include_once "ORM/ActCine.php";
include_once "ORM/ActTeatro.php";
include_once "transaccion/Base.php";
include_once "transaccion/abmTeatro.php";
include_once "transaccion/abmActMusical.php";
include_once "transaccion/abmActTeatro.php";
include_once "transaccion/abmActCine.php";

function seleccionar(){
    echo "--------------------------------------------------------------\n";
    echo "\n ( 1 ) Crear nuevo teatro"; 
    echo "\n ( 2 ) Cambiar nombre de un teatro"; 
    echo "\n ( 3 ) Cambiar dirección de un teatro"; 
    echo "\n ( 4 ) Generar una actividad"; 
    echo "\n ( 5 ) Modificar una actividad"; 
    echo "\n ( 6 ) Eliminar una actividad";
    echo "\n ( 7 ) Eliminar un teatro"; 
    echo "\n ( 8 ) Visualizar datos del teatro";
    echo "\n ( 9 ) Mostrar costos del teatro";
    echo "\n ( 10 ) Salir";
    do{
        echo "\n Indique una opción válida:";
        $opcion=trim(fgets(STDIN));
    }while (($opcion<1) || ($opcion>10));
    
    echo "--------------------------------------------------------------\n";
    return $opcion;
}

//CREACION BASE DE DATOS
$conexion= new mysqli("127.0.0.1","root","");
if ($conexion->connect_error){
    die("Conexion fallida: ".$conexion->connect_error."\n");    
}
$instruccion="create DATABASE IF NOT EXISTS bdteatro";
if ($conexion->query($instruccion)===true){
    echo "Base de datos creada correctamente...\n";
}else{
    die("Error al crear base de datos: ".$conexion->connect_error."\n");
}
$base= new BaseDatos();
$base->crearTeatro(); //Genera las tablas

do{
    $opcion=seleccionar();
    switch ($opcion){
        case 1: //Nuevo teatro
            echo "Ingrese nombre para el nuevo teatro: ";
            $nombre=trim(fgets(STDIN));
            echo "Ingrese la direccion del teatro: ";
            $direccion=trim(fgets(STDIN));
            $abm=new abmTeatro();
            $resp=$abm->ingresarTeatro($nombre,$direccion);
            if ($resp){
                echo "Los datos del teatro fueron ingresados de forma correcta\n";
            }
            else{
                echo "No se pudo cargar el teatro en la base\n";
            }
            break;
        case 2: //Cambiar nombre de un teatro
            $abm=new abmTeatro();
            echo "Ingrese id del teatro: ";
            $id=trim(fgets(STDIN));
            $objTeatro=$abm->seleccionTeatro($id);
            echo "Ingrese nuevo nombre para el teatro: ";
            $nuevoNombre=trim(fgets(STDIN));
            $resp=$abm->modificarTeatro($objTeatro,["nombre"=>$nuevoNombre]);
            if ($resp){
                echo "El nombre del teatro se cambio con exito\n";
            }
            else{
                echo "No se pudo actualizar el nombre en la base\n";
            }
            break;
        case 3: //Cambia direccion de un teatro
            $abm=new abmTeatro();
            echo "Ingrese id del teatro: ";
            $id=trim(fgets(STDIN));
            $objTeatro=$abm->seleccionTeatro($id);
            echo "Ingrese nueva direccion para el teatro: ";
            $nuevaDir=trim(fgets(STDIN));
            $resp=$abm->modificarTeatro($objTeatro,["nombre"=>null,"direccion"=>$nuevaDir]);
            if ($resp){
                echo "La direccion del teatro se cambio con exito\n";
            }
            else{
                echo "No se pudo actualizar la direccion en la base\n";
            }
            break;
        case 4: //Nueva Actividad
            echo "Ingrese id del teatro: ";
            $idTeatro=trim(fgets(STDIN));
            $objTeatro=new Teatro();
            $objTeatro->Buscar($idTeatro,true);//Seteo los valores del teatro que estan en la base
            echo "Que tipo de actividad desea generar?(cine/teatro/musical): ";
            $tipo=trim(fgets(STDIN));
            echo "Ingrese nombre de la nueva actividad: ";
            $nombre=trim(fgets(STDIN));
            echo "Ingrese precio de la nueva actividad: ";
            $precio=trim(fgets(STDIN));
            $control=false;
            while (!$control){
                echo "Ingrese horario de inicio(hora): ";
                $inicioHora=trim(fgets(STDIN));
                echo "Ingrese horario de inicio(minuto): ";
                $inicioMinutos=trim(fgets(STDIN));                
                echo "Ingrese duracion de la actividad (en minutos): ";
                $duracion=trim(fgets(STDIN));
                echo "Ingrese día de la actividad: ";
                $dia=trim(fgets(STDIN));
                echo "Ingrese mes: ";
                $mes=trim(fgets(STDIN));
                echo "Ingrese año: ";
                $anio=trim(fgets(STDIN));
                $control=$objTeatro->controlHorarios($inicioHora,$inicioMinutos,$duracion,$dia,$mes,$anio);
                if (!$control){
                    echo "Los horarios de la nueva actividad se solapan con otra actividad, ingrese otro horario.\n";
                }    
            }  
            $inicio=["hora"=>$inicioHora,"minutos"=>$inicioMinutos];
            $fecha=["dia"=>$dia,"mes"=>$mes,"año"=>$anio];
            
            if ($tipo=="cine"){
                echo "Ingrese país de la pelicula: ";
                $pais=trim(fgets(STDIN));
                echo "Ingrese género de la pelicula: ";
                $genero=trim(fgets(STDIN));
                $abm=new abmActCine();
                $resp=$abm->ingresarActividad(["idActividad"=>null,"objTeatro"=>$objTeatro,"nombre"=>$nombre,"inicio"=>$inicio,"duracion"=>$duracion,"precio"=>$precio,"fecha"=>$fecha,"genero"=>$genero,"pais"=>$pais]);
            }
            elseif ($tipo=="musical"){
                echo "Ingrese nombre del director: ";
                $director=trim(fgets(STDIN));
                echo "Ingrese cantidad de personas en escena: ";
                $cantPersonas=trim(fgets(STDIN));
                $abm=new abmActMusical();
                $resp=$abm->ingresarActividad(["idActividad"=>null,"objTeatro"=>$objTeatro,"nombre"=>$nombre,"inicio"=>$inicio,"duracion"=>$duracion,"precio"=>$precio,"fecha"=>$fecha,"director"=>$director,"actores"=>$cantPersonas]);
            }
            else{
                $abm=new abmActTeatro();
                $resp=$abm->ingresarActividad(["idActividad"=>null,"objTeatro"=>$objTeatro,"nombre"=>$nombre,"inicio"=>$inicio,"duracion"=>$duracion,"precio"=>$precio,"fecha"=>$fecha]);
            }
            if ($resp){
                echo "Los datos de la funcion fueron ingresados de forma correcta\n";
            }
            else{
                echo "No se pudo cargar la funcion en la base\n";
            }
            break;
        case 5: // Cambiar valor en atributo de actividad
            echo "Ingresar id de la actividad: ";
            $idAct=trim(fgets(STDIN));
            echo "Ingresar tipo de actividad: ";
            $tipo=trim(fgets(STDIN));
            echo "Ingresar atributo a cambiar: ";
            $mod["atributo"]=trim(fgets(STDIN));
            echo "Ingrese nuevo valor para el atributo: \n";
            $mod["valor"]=trim(fgets(STDIN));
            if ($tipo=="cine"){
                $abmAct=new abmActCine();
            }elseif($tipo=="teatro"){
                $abmAct=new abmActTeatro();
            }elseif($tipo=="musical"){
                $abmAct=new abmActMusical();
            }            
            $objAct=$abmAct->seleccionActividad($idAct);
            $resp=$abmAct->modificar($objAct,$mod);
            if ($resp){
                echo $mod["atributo"]." se cambio con exito en la base\n";
            }
            else{
                echo "No se pudo actualizar ".$mod["atributo"]." en la base\n";
            }
            break;
        case 6: //Eliminar una actividad
            echo "Ingresar id de la actividad: ";
            $idAct=trim(fgets(STDIN));
            echo "Ingresar tipo de actividad: ";
            $tipo=trim(fgets(STDIN));
            if ($tipo=="cine"){
                $abmAct=new abmActCine();
            }elseif($tipo=="teatro"){
                $abmAct=new abmActTeatro();
            }elseif($tipo=="musical"){
                $abmAct=new abmActMusical();
            }    
            $resp=$abmAct->eliminarActividad($idAct);
            if ($resp){
                echo "La actividad se elimino de la base con exito\n";
            }
            else{
                echo "La actividad no se pudo eliminar de la base\n";
            }
            break;
        case 7: //Eliminar un teatro
            echo "Ingresar id del teatro: ";
            $idTeatro=trim(fgets(STDIN));
            $abmTeatro=new abmTeatro();
            $objTeatro=$abmTeatro->seleccionTeatro($idTeatro);            
            $resp=$abmTeatro->eliminarTeatro($objTeatro);
            if ($resp){
                echo "\nEl teatro y sus funciones fueron eliminados correctamente.\n";
            }else{
                echo "\nNo se pudo eliminar el teatro.\n";
            }
            break;
        case 8: //Visualiza el teatro y sus actividades
            echo "Ingrese id del teatro: ";
            $idTeatro=trim(fgets(STDIN));
            $abmTeatro=new abmTeatro();
            $objTeatro=$abmTeatro->seleccionTeatro($idTeatro);
            echo $objTeatro;
            break;
        case 9: // Ingresa por parametro el mes del que se quiere saber los costos y visualiza los mismos
            echo "Ingrese id del teatro: ";
            $idTeatro=trim(fgets(STDIN));
            $abmTeatro=new abmTeatro();
            $objTeatro=$abmTeatro->seleccionTeatro($idTeatro);
            echo "Ingrese mes (numero): ";
            $mes=trim(fgets(STDIN));
            $costos=$objTeatro->darCostos($mes);
            echo "Los costos del teatro en el mes ",$mes," son: ",$costos,"\n";
            break;
    }
}while ($opcion!=10);