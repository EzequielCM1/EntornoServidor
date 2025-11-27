<?php
    $temperatura = rand(-5, 45);

    if ($temperatura >=30){
        echo "$temperatura hace calor";
    }else if ($temperatura <15){
        echo "$temperatura hace frio";
    }else{
        echo "$temperatura el clia es templado";
    }
?>