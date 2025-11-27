<?php
    $dia = 0;

     if(isset($_GET['dia'])){
        $dia = $_GET['dia'];
    }else{
        $dia = rand(1, 7);
    }

     switch ($dia){
        case 1 :
            echo "<h1>Es Lunes </h1>";
            break;
        case 2:
            echo "<h1>Es Martes </h1>";
            break;
        case 3:
            echo "<h1>Es Miércoles</h1>";
            break;
        case 4:
            echo "<h1>Es Jueves</h1>";
            break;
        case 5 : 
            echo "<h1>Es Viernes</h1>";
            break;
        case 6 :
            echo "<h1>Es Sabado</h1>";
            break;
        case 7 :
            echo "<h1>Es Domingo</h1>";
            break;
     };


     $restante = 7 - $dia;

     if ($restante == 0)
       echo "<h1>Quedan 7 dias</h1>";
    else
     echo "<h1>Quedan $restante dias</h1>";
?>