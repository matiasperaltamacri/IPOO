<?php
include_once "TP3 Teatro.php";
include_once "TP3 ActMusical.php";
include_once "TP3 ActCine.php";
include_once "TP3 ActTeatro.php";

function seleccionar(){
    echo "--------------------------------------------------------------\n";
    echo "\n ( 1 ) Crear nuevo teatro"; 
    echo "\n ( 2 ) Cambiar nombre de un teatro"; 
    echo "\n ( 3 ) Cambiar dirección de un teatro"; 
    echo "\n ( 4 ) Generar una actividad"; 
    echo "\n ( 5 ) Cambiar nombre de una actividad"; 
    echo "\n ( 6 ) Cambiar precio de una actividad";
    echo "\n ( 7 ) Verificar horario de actividades"; 
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
function elegirTeatro($nombre,$coleccion){    // Retorna el teatro con el que se quiere trabajar
    $teatro=[];
    $cantidad=count($coleccion);
    for ($n=0;$n<$cantidad;$n++){
        $actual=$coleccion[$n]->getNombre();
        if ($actual==$nombre){
            $teatro=$coleccion[$n];
        }
    }
    return $teatro;
}
$colTeatros=[];
$contTeatro=0;
do{
    $opcion=seleccionar();
    switch ($opcion){
        case 1: //Nuevo teatro
            echo "Ingrese nombre para el nuevo teatro: ";
            $nombre=trim(fgets(STDIN));
            echo "Ingrese la direccion del teatro: ";
            $direccion=trim(fgets(STDIN));
            $colTeatros[$contTeatro]=new Teatro($nombre,$direccion,[]);
            $contTeatro++;
            break;
        case 2: //Cambiar nombre de un teatro
            echo "Ingrese nombre del teatro: ";
            $teatro=trim(fgets(STDIN));
            $teatroElegido=elegirTeatro($teatro,$colTeatros);
            echo "Ingrese nuevo nombre para el teatro: ";
            $nuevoNombre=trim(fgets(STDIN));
            $teatroElegido->cambiarNombre($nuevoNombre);
            break;
        case 3: //Cambia direccion de un teatro
            echo "Ingrese nombre del teatro: ";
            $teatro=trim(fgets(STDIN));
            $teatroElegido=elegirTeatro($teatro,$colTeatros);
            echo "Ingrese nueva direccion para el teatro: ";
            $nuevaDir=trim(fgets(STDIN));
            $teatroElegido->cambiarDireccion($nuevaDir);
            break;
        case 4: //Nueva Actividad
            echo "Ingrese nombre del teatro: ";
            $teatro=trim(fgets(STDIN));
            $teatroElegido=elegirTeatro($teatro,$colTeatros);
            echo "Que tipo de actividad desea generar?(cine/teatro/musical): ";
            $tipo=trim(fgets(STDIN));
            echo "Ingrese nombre de la nueva actividad: ";
            $nombre=trim(fgets(STDIN));
            echo "Ingrese precio de la nueva actividad: ";
            $precio=trim(fgets(STDIN));
            echo "Ingrese horario de inicio(hora): ";
            $inicioHora=trim(fgets(STDIN));
            echo "Ingrese horario de inicio(minuto): ";
            $inicioMinutos=trim(fgets(STDIN));
            $inicio=["hora"=>$inicioHora,"minutos"=>$inicioMinutos];
            echo "Ingrese duracion de la actividad (en minutos): ";
            $duracion=trim(fgets(STDIN));
            echo "Ingrese día de la actividad: ";
            $dia=trim(fgets(STDIN));
            echo "Ingrese mes: ";
            $mes=trim(fgets(STDIN));
            echo "Ingrese año: ";
            $anio=trim(fgets(STDIN));
            if ($tipo=="cine"){
                echo "Ingrese país de la pelicula: ";
                $pais=trim(fgets(STDIN));
                echo "Ingrese género de la pelicula: ";
                $genero=trim(fgets(STDIN));
                $actividad=new ActCine($nombre,$inicio,$duracion,$precio,["dia"=>$dia,"mes"=>$mes,"año"=>$anio],$genero,$pais);
            }
            elseif ($tipo=="musical"){
                echo "Ingrese nombre del director: ";
                $director=trim(fgets(STDIN));
                echo "Ingrese cantidad de personas en escena: ";
                $cantPersonas=trim(fgets(STDIN));
                $actividad=new ActMusical($nombre,$inicio,$duracion,$precio,["dia"=>$dia,"mes"=>$mes,"año"=>$anio],$director,$cantPersonas);
            }
            else{
                $actividad=new ActTeatro($nombre,$inicio,$duracion,$precio,["dia"=>$dia,"mes"=>$mes,"año"=>$anio]);
            }
            
            $teatroElegido->agregarActividad($actividad);
            break;
        case 5: // Cambiar nombre de actividad
            echo "Ingrese nombre del teatro: ";
            $teatro=trim(fgets(STDIN));
            $teatroElegido=elegirTeatro($teatro,$colTeatros);
            echo "Ingresar nombre de la actividad a la que quiere cambiar: ";
            $act=trim(fgets(STDIN));
            echo "Ingrese nuevo nombre para la actividad: \n";    //Por alguna razón no reconoce la ñ
            $nuevoNombre=trim(fgets(STDIN));
            $teatroElegido->cambiarNombreActividad($act,$nuevoNombre);
            break;
        case 6: //Cambiar precio de la actividad
            echo "Ingrese nombre del teatro: ";
            $teatro=trim(fgets(STDIN));
            $teatroElegido=elegirTeatro($teatro,$colTeatros);
            echo "Ingresar nombre de la actividad a la que quiere cambiar: ";
            $act=trim(fgets(STDIN));
            echo "Ingrese nuevo precio para la actividad: \n";  
            $nuevoPrecio=trim(fgets(STDIN));
            $teatroElegido->cambiarPrecioActividad($act,$nuevoPrecio);
            break;
        case 7: //Verificar Horarios
            echo "Ingrese nombre del teatro: ";
            $teatro=trim(fgets(STDIN));
            $teatroElegido=elegirTeatro($teatro,$colTeatros);
            $verificado=$teatroElegido->controlHorarios();
            echo $verificado;
            break;
        case 8: //Visualiza el teatro y sus actividades
            echo "Ingrese nombre del teatro: ";
            $teatro=trim(fgets(STDIN));
            $teatroElegido=elegirTeatro($teatro,$colTeatros);
            echo $teatroElegido;
            break;
        case 9: // Ingresa por parametro el mes del que se quiere saber los costos y visualiza los mismos
            echo "Ingrese nombre del teatro: ";
            $teatro=trim(fgets(STDIN));
            $teatroElegido=elegirTeatro($teatro,$colTeatros);
            echo "Ingrese mes (numero): ";
            $mes=trim(fgets(STDIN));
            $costos=$teatroElegido->darCostos($mes);
            echo "Los costos del teatro en el mes ",$mes," son: ",$costos,"\n";
            break;
    }
}while ($opcion!=10);