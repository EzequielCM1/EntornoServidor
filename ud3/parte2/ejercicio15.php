<?php

    
    function crearTabla($numero){
        echo "<table>";
        $cantidad = 0;
            for($i =1; $i <= $numero; $i++){
                
                echo "<tr>";
                    for($e =1; $e <= $numero; $e++){
                        $cantidad ++;
                        echo "<td>$cantidad</td>";
                    }
               echo "</tr>";
            }
        echo "</table>";
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Un-Minified version -->
<link rel="stylesheet" href="https://cdn.simplecss.org/simple.css">
    <title>Document</title>
</head>
<body><tr></tr>
    
    <h1>Ejericio15</h1>
    <p>Crea una función llamada generarTabla que reciba un número entero como parámetro. Este número representará tanto el número de filas como el número de columnas de la tabla. La función debe generar y devolver una cadena de texto que contenga una tabla HTML, donde cada celda esté llena con números correlativos, comenzando desde 1. Luego, el script debe llamar a la función varias veces con diferentes valores y mostrar las tablas generadas.
    </p>
    <?php
    echo crearTabla(4);
    echo crearTabla(7);
    echo crearTabla(10);
    ?>
</body>
</html>