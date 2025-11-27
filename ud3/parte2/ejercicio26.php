<?php

    $mensaje = "";

    $nombre_animal = $_GET['nombre'] ?? "";

$animales = [    
    ['nombre' => 'Simba', 'especie' => 'León', 'interacciones' => 10],
    ['nombre' => 'Nala', 'especie' => 'León', 'interacciones' => 20],
    ['nombre' => 'Dumbo', 'especie' => 'Elefante', 'interacciones' => 12],
    ['nombre' => 'George', 'especie' => 'Mono', 'interacciones' => 8],
    ['nombre' => 'Lola', 'especie' => 'Elefante', 'interacciones' => 16],
];


     function registrar_interaccion (&$animales, $nombre_animal){
        $encontrado = false ;

        if (empty($animales)) {
        return "El zoológico está vacío<br>";
     }

        foreach($animales as $i => $animal){
            if($animal['nombre'] == $nombre_animal){
                $animales[$i]['interacciones']++;
                $mensaje = "Se ha encontrado el animal y se ha aumentado la interaccion<br>";
                $encontrado = true;
                break;
            }
        }
        if($encontrado == false){
            $mensaje = "No se ha encontrado el animal<br>";
        }

        return $mensaje;
     }

   


    function animales_mas_interactivos($animales){
        $interacciones = array_column($animales, 'interacciones');

        // mostramos el numero maximo de interacciones 
        $max_interac = max($interacciones);

        foreach($animales as $e => $animal){
            if($animal['interacciones'] == $max_interac){
                $max_animales [] = $animal;
            }
        }
        return $max_animales;

    }

    function promedio_interacciones_por_especie($animales){

        $totales = [];
        $contadores = [];

        foreach($animales as $animal){
             $especie = $animal['especie'];
             $interacciones = $animal['interacciones'];

             if (!isset($totales[$especie])) {
            $totales[$especie] = 0;
            $contadores[$especie] = 0;
        }

        //  Sumamos las interacciones al total de esa especie
        $totales[$especie] += $interacciones;

        //  Contamos cuántos animales hay en esa especie
        $contadores[$especie]++;
        }
        
        $promedios = [];

        foreach ($totales as $especie => $suma) {
        $promedios[$especie] = $suma / $contadores[$especie];
        }

    return $promedios;

    }


      if ($nombre_animal !== "") {
    $mensaje .= registrar_interaccion($animales, $nombre_animal);
    $animales_maximos = animales_mas_interactivos($animales);
    $promediosS = promedio_interacciones_por_especie($animales);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <h1>Registros Animales en un zoologico</h1>
    <link rel='stylesheet' href='https://cdn.simplecss.org/simple.min.css'>
    <?php 
    echo "<pre>$mensaje</pre>";
?>

<?php
    echo "<h3>Lista actual de animales:</h3>";
    echo "<pre>";
    print_r($animales);
    echo "</pre>";
?>
    <?php
    echo "<h3>Animales con maxima interacciones:</h3>";
    echo "<pre>";
    print_r($animales_maximos);
    echo "</pre>";
    ?>
    <?php
    echo "<h3>Promedio de interacciones</h3>";
    echo "<pre>";
    print_r($promediosS);
    echo "</pre>";
    ?>

</head>
<body>
    
</body>
</html>