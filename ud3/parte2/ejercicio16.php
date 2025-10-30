<?php


    $mensaje = "";
    $error = false;
    if(isset($_GET['notas'])){
        $notas = $_GET['notas'];
        $mensaje = "<p>SE han guardado las notas</p>";
    }else{
        $mensaje ="<p>No se han recivido las notas</p>";
    }

    if(!isset($notas)){
        $error = true;
        $mensaje = "se ha producido un error con las notas";
    }

    if (!$error) {
        //Esto lo trasforma en array
        $a_notas = explode(",", $notas);
        foreach($a_notas as $notas){
            if($notas!=floatval($notas)){
                $error = true;
                $mensaje .= "error en los valores de las notas<br>";
                break;
            }elseif($notas<0 || $notas>10){
                $error = true;
                $mensaje .= "la nota debe estar entre el 1 y el 10<br>";
                break;
            }
        }
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
    
    <h1>Ejericio16</h1>
    <p>Crear un script que permita calcular la media de las notas de un grupo de estudiantes y clasificar los resultados en función de la media obtenida. Para ello: <br>
paso de parámetros: La aplicación debe recibir un array de notas a través de la URL. Las notas se pasarán en la siguiente estructura: ej16.php?notas=6.5,7.0,8.5,9.0,4.5 <br>
Validación de Notas:  Cada nota debe ser un número entre 0 y 10. Si hay alguna nota fuera de este rango, el programa debe mostrar un mensaje indicando que las notas deben estar entre 0 y 10 y terminar su ejecución. <br>
Función: Definir una función llamada calcularMedia($notas) que reciba el array de notas como parámetro y retorne la media de las notas. Hacer uso de la función en el script para para calcular la media de las notas obtenidas. <br>
Mensaje: Se mostrará un mensaje por pantalla indicando la media del grupo y  si el grupo ha aprobado o suspendido (aprobado si su media es >=5). Además debe contar cuántas notas son aprobadas (>= 5) y cuántas son suspendidas (< 5). <br>
	Nota: puedes usar la función explode, array_sum.

</p>
        <pre>
    <?php 
    echo  $mensaje;
    print_r($a_notas);
     ?>
    </pre>
    
    <p>Enlaces de prueba:</p>
    <ul>
        <li><a href="http://localhost/php/ud3/parte2/ejercicio16.php?notas=6.5,7.0,8.5,9.0,4.5">Prueba1</a></li><br>
    </ul>
</body>
</html>