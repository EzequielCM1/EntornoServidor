<?php
    $frutas = ['manzana', 'platano', 'kiwi', 'pera'];
  //añdir elemntos

    $frutas [4]= 'fresas';
    $frutas []= 'melon';


    echo "<pre>";
    print_r($frutas);
    echo "</pre>";
  
    // probamos las funcionesimplode
    $a = implode(",", $frutas);
    echo $a;

    //preobamos el explode
    $cadena = "juan;pepe;juanalberto;CJ";
    $personas = explode(";",$cadena);

    echo "<pre>";
    print_r($personas);
    echo "</pre>";



    //// 31

    $personas1 = ['a', 'b', 'c', 'd'];

    $datos = array(2,3,4,5,6,7,8);

    //asociativo 
    $personas4 = [
        "nombre"=>'Juan',
        "edad"=>'23',
        "profesion"=>'a'
    ];

    foreach($personas4 as $clave=>$datos){
        echo $datos."<br>";
    }

    echo "<pre>";
    print_r($personas4);
    echo "</pre>";
    
    /*
    $numero_elemtos = count($datos);
    echo $numero_elemtos;
*/
    $combinamos = array_merge($frutas, $personas1, $cadena);
    echo $combinamos;
    ?>