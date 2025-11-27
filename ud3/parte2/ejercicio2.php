<?php
    if(isset($_GET['dia'])){
        $dia = $_GET['dia'];
    }else{
        $dia = rand(1, 7);
    }

    echo "<h1>Dia de la semana $dia</h1>";
    

    if ($dia <= 5)
        echo "Es un dia laboral";
    elseif ($dia > 5)
        echo "Es fin de semana";
    elseif ($dia <=0 || $dia >7)
        echo "El dia de la semana no es correcto";
    


?>