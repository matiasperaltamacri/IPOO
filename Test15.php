<?php
include_once "15 Teatro.php";
function seleccionar(){
    echo "--------------------------------------------------------------\n";
    echo "\n ( 1 ) Cambiar nombre del teatro"; 
    echo "\n ( 2 ) Cambiar dirección"; 
    echo "\n ( 3 ) Cambiar nombre de una función"; 
    echo "\n ( 4 ) Cambiar precio de una función";
    echo "\n ( 5 ) Visualizar datos del teatro";
    echo "\n ( 6 ) Salir";
    do{
        echo "\n Indique una opción válida:";
        $opcion=trim(fgets(STDIN));
    }while (($opcion<1) || ($opcion>6));
    
    echo "--------------------------------------------------------------\n";
    return $opcion;
}

$funcTeatro=[1=>["nombre"=>"Los Padecientes","precio"=>1700],
            2=>["nombre"=>"Piñon Fijo","precio"=>700],
            3=>["nombre"=>"Romeo y Julieta","precio"=>600],
            4=>["nombre"=>"La abuela Norma","precio"=>1200]
];
$colon=new Teatro("Colon","Av. 8",$funcTeatro);
do{
    $opcion=seleccionar();
    switch ($opcion){
        case 1: 
            echo "Ingrese nuevo nombre para el teatro: ";
            $nombre=trim(fgets(STDIN));
            $colon->otroNombre($nombre);
            break;
        case 2:
            echo "Ingrese nueva dirección para el teatro: \n";
            $direccion=trim(fgets(STDIN));
            $colon->otraDireccion($direccion);
            break;
        case 3: // Cambiar nombre de funcion
            do{
                echo "A que función desea cambiarle el nombre? (1-4): \n";
                $num=trim(fgets(STDIN));
            } while (($num<1) || ($num>4));
            echo "Ingrese nuevo nombre para la función: \n";
            $nombre=trim(fgets(STDIN));
            $colon->otraFuncion($num,$nombre);
        break;
        case 4: //Cambiar precio de la función
            do{
                echo "A que función desea cambiarle el precio? (1-4): \n";
                $num=trim(fgets(STDIN));
            } while (($num<1) || ($num>4));
            echo "Ingrese nuevo precio para la función: \n";
            $precio=trim(fgets(STDIN));
            $colon->otroPrecio($num,$precio);
            break;
        case 5:
            echo $colon;
    }
}while ($opcion!=6);