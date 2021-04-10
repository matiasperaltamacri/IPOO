<?php
include_once "8 Teatro.php";
include_once "8 Funcion.php";
function seleccionar(){
    echo "--------------------------------------------------------------\n";
    echo "\n ( 1 ) Crear nuevo teatro"; 
    echo "\n ( 2 ) Cambiar nombre de un teatro"; 
    echo "\n ( 3 ) Cambiar dirección de un teatro"; 
    echo "\n ( 4 ) Generar una función"; 
    echo "\n ( 5 ) Cambiar nombre de una función"; 
    echo "\n ( 6 ) Cambiar precio de una función";
    echo "\n ( 7 ) Verificar horario de funciones"; 
    echo "\n ( 8 ) Visualizar datos del teatro";
    echo "\n ( 9 ) Salir";
    do{
        echo "\n Indique una opción válida:";
        $opcion=trim(fgets(STDIN));
    }while (($opcion<1) || ($opcion>9));
    
    echo "--------------------------------------------------------------\n";
    return $opcion;
}
function elegir($nombre,$coleccion){    // Retorna el teatro con el que se quiere trabajar
    $arreglo=[];
    $cantidad=count($coleccion);
    for ($n=0;$n<$cantidad;$n++){
        $actual=$coleccion[$n]->getNombre();
        if ($actual==$nombre){
            $arreglo=$coleccion[$n];
        }
    }
    return $arreglo;
}
function posicion($nombre,$coleccion){  // Retorna la posicion de la funcion que se busca 
    $posi="";
    $cantidad=count($coleccion);
    for ($n=0;$n<$cantidad;$n++){
        $actual=$coleccion[$n]->getNombre();
        if ($actual==$nombre){
            $posi=$n;
        }
    }
    return $posi;
}
function verificaHorario($colFunc){     // Retorna String con los horarios que se superponen
    $cantFunc=count($colFunc);
    $verificado="";
    $encontrado=false;
    for ($i=0;$i<$cantFunc;$i++){
        $inicioF1=$colFunc[$i]->getInicio();
        $finF1=$inicioF1+$colFunc[$i]->getDuracion();
        for ($n=0;$n<$cantFunc;$n++){
            if (!(($colFunc[$i]->getNombre())==($colFunc[$n]->getNombre()))){
                $inicioF2=$colFunc[$n]->getInicio();
                $finF2=$inicioF2+$colFunc[$n]->getDuracion();
                if ((($inicioF2>=$inicioF1)&&($inicioF2<$finF1))||(($finF2>$inicioF1)&&($finF2<$finF1))){
                    $verificado=$verificado."Los horarios de ".$colFunc[$i]->getNombre()." y ".$colFunc[$n]->getNombre()." se solapan entre si.\n";
                    $encontrado=true;
                }
            }
        }
    }
    if (!$encontrado){
        $verificado="No se encontraron superposiciones entre los horarios.\n";
    }
    return $verificado;
}
$func1= new Funcion("Los Padecientes",1950,130,1700);
$func2= new Funcion("El Payaso Pombo",1700,100,700);
$func3= new Funcion("Romeo y Julieta",1800,200,600);
$func4= new Funcion("La abuela Norma",2200,130,1200);
$funcTeatro=[$func1,$func2,$func3,$func4];
$colecTeatros[0]=new Teatro("Colon","Av. 8",$funcTeatro);   //Objeto Teatro precargado (dentro de la coleccion) para pruebas.
do{
    $opcion=seleccionar();
    switch ($opcion){
        case 1: //Nuevo Teatro
            echo "Ingrese nombre para el nuevo teatro: \n";
            $nuevoTeatro=trim(fgets(STDIN));
            echo "Ingrese dirección para el teatro: \n";
            $direccion=trim(fgets(STDIN));
            $cantTeatros=count ($colecTeatros);
            $colecTeatros[$cantTeatros]= new Teatro($nuevoTeatro,$direccion,[]);
            break;
        case 2: //Cambiar nombre de un teatro
            echo "Ingrese nombre del teatro: ";
            $nombre=trim(fgets(STDIN));
            $teatroElegido=elegir($nombre,$colecTeatros);
            echo "Ingrese nuevo nombre para el teatro: ";
            $nuevoNombre=trim(fgets(STDIN));
            $teatroElegido->otroNombre($nuevoNombre);
            break;
        case 3: //Cambia direccion de un teatro
            echo "Ingrese nombre del teatro: ";
            $nombre=trim(fgets(STDIN));
            $teatroElegido=elegir($nombre,$colecTeatros);
            echo "Ingrese nueva dirección para el teatro: \n";
            $direccion=trim(fgets(STDIN));
            $teatroElegido->otraDireccion($direccion);
            break;
        case 4: //Nueva funcion en un teatro especifico
            echo "Ingrese nombre del teatro: ";
            $nombre=trim(fgets(STDIN));
            $teatroElegido=elegir($nombre,$colecTeatros);
            echo "Ingrese nombre para la nueva funcion: ";
            $nuevoNombre=trim(fgets(STDIN));
            echo "Ingrese horario de la nueva funcion(hhmm): ";
            $nuevaHora=trim(fgets(STDIN));
            echo "Ingrese duracion para la nueva funcion(hmm): ";
            $nuevaDurac=trim(fgets(STDIN));
            echo "Ingrese precio para la nueva funcion: ";
            $nuevoPrecio=trim(fgets(STDIN));
            $nuevaFunc= new Funcion($nuevoNombre,$nuevaHora,$nuevaDurac,$nuevoPrecio);
            $funcionesTeatro=$teatroElegido->getFunciones();
            $cantFunc=count ($funcionesTeatro);
            $funcionesTeatro[$cantFunc]=$nuevaFunc;
            $teatroElegido->setFunciones($funcionesTeatro);
            break;
        case 5: // Cambiar nombre de funcion
            echo "Ingrese nombre del teatro: ";
            $nombre=trim(fgets(STDIN));
            $teatroElegido=elegir($nombre,$colecTeatros);
            $funcionesTeatro=$teatroElegido->getFunciones();
            echo "Ingresar nombre de la funcion a la que quiere cambiar: ";
            $funcActual=trim(fgets(STDIN));
            $funcionElegida=elegir($funcActual,$funcionesTeatro);
            $posicion=posicion($funcActual,$funcionesTeatro);
            echo "Ingrese nuevo nombre para la función: \n";    //Por alguna razón no reconoce la ñ
            $nuevaFunc=trim(fgets(STDIN));
            $teatroElegido->otraFuncion($posicion,$nuevaFunc);
            break;
        case 6: //Cambiar precio de la función
            echo "Ingrese nombre del teatro: ";
            $nombre=trim(fgets(STDIN));
            $teatroElegido=elegir($nombre,$colecTeatros);
            $funcionesTeatro=$teatroElegido->getFunciones();
            echo "Ingresar nombre de la funcion a la que quiere cambiar: ";
            $funcActual=trim(fgets(STDIN));
            $funcionElegida=elegir($funcActual,$funcionesTeatro);
            $posicion=posicion($funcActual,$funcionesTeatro);
            echo "Ingrese nuevo precio para la función: \n"; 
            $nuevoPrecio=trim(fgets(STDIN));
            $teatroElegido->otroPrecio($posicion,$nuevoPrecio);
            break;
        case 7: //Verificar horarios
            echo "Ingrese nombre del teatro: ";
            $nombre=trim(fgets(STDIN));
            $objTeatroElegido=elegir($nombre,$colecTeatros);
            $colecFunc=$objTeatroElegido->getFunciones();
            $resultado= verificaHorario($colecFunc);
            echo "\n",$resultado;
            break;
        case 8: //Visualiza el teatro y sus funciones
            echo "Ingrese nombre del teatro: ";
            $nombre=trim(fgets(STDIN));
            $visual=elegir($nombre,$colecTeatros);
            echo $visual;
            break;
    }
}while ($opcion!=9);