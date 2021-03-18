<?php 
/*
Funcion datosVinos
Obtiene como parámetro de entrada un arreglo y a partir de este calcula la cantidad por variedad y hace un promedio de los precios de dicha variedad. Estos datos son guardados en un nuevo arreglo que pasa a ser el retorno de la función.
*/
function datosVinos($datos){
    $cant=0;    // Cantidad de botellas
    $valorT=0;  // Suma de los precios de una variedad
    $cont=0;    // Para identificar en que variedad está posicionado el foreach
    $aux=0;     // Contador para luego promediar los precios
    $vinoData=[];   //Nuevo arreglo donde se almacenan los datos requeridos
    foreach($datos as $datos2){
        $cont=$cont+1;
 	    foreach($datos2 as $datos3){
            foreach ($datos3 as $datos4 =>$dato){
                if ($datos4=="cantidad"){
                    $cant=$cant+$dato;
                }
                elseif ($datos4=="precio"){
                    $aux=$aux+1;
                    $valorT=$valorT+$dato;
                }
            }
 	    }
        if ($cont==1){
            $prom=round($valorT/$aux,2);     // Promedia los precios, redondea el float a 2 decimales.
            $vinoData["Malbec"]=["cantidad"=>$cant,"precioProm"=>$prom];
            $cant=0;
            $valorT=0;
            $aux=0;
        } 
        elseif ($cont==2){
            $prom=round($valorT/$aux,2);
            $vinoData["Cabernet Sauvignon"]=["cantidad"=>$cant,"precioProm"=>$prom];
            $cant=0;
            $valorT=0;
            $aux=0;
        }
        else{
            $prom=round($valorT/$aux,2);
            $vinoData["Merlot"]=["cantidad"=>$cant,"precioProm"=>$prom];
        }
 	}
    return($vinoData);
}
/*
Funcion main
Crea un arreglo con las características del vino, invoca la función datosVinos y visualiza el retorno de dicha función.
*/
function main(){
    $vinos=[];
    $vinos=[
        "Malbec"=>[
            ["variedad"=>"dulce","cantidad"=>60,"año"=>1986,"precio"=>2500],
            ["variedad"=>"seco","cantidad"=>30,"año"=>1970,"precio"=>2800]
        ],
        "Cabernet Sauvignon"=>[
            ["variedad"=>"tinto","cantidad"=>10,"año"=>1890,"precio"=>5700],
            ["variedad"=>"blanco","cantidad"=>19,"año"=>1910,"precio"=>5000],
            ["variedad"=>"rosado","cantidad"=>55,"año"=>1993,"precio"=>2100]
        ],
        "Merlot"=>[
            ["variedad"=>"espumoso","cantidad"=>200,"año"=>2010,"precio"=>1500],
            ["variedad"=>"espumoso","cantidad"=>150,"año"=>1999,"precio"=>1900]
        ]
    ];
    $final=datosVinos($vinos);
    print_r($final);
}
// Programa Principal. Ejecuta la función main
main();