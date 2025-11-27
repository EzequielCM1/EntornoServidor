<?php
    $edades = [18, 19, 20, 20 , 31, 21 ,25, 12];
    $indice = 0;
    $total = 0;
    $mayor = 0;

    // $total = array_sum($edades);  --> esta forma es mas rapida para sumar 
    do{
        $total += $edades[$indice];

        if($edades[$indice] >= 18){
            $mayor++;
    }
        $indice ++;
    }while($indice < count($edades));


    $media = $total / count($edades);


    echo "<h1>La suma de las edades es $total </h1>";
     echo "<h1>Hay $mayor personas mayores de edad </h1>";
     echo "<h1>La media es de $media </h1>";
?>