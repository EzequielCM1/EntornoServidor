<?php
    $estudiantes = [
        "Juan" => 5,
        "Alberto" => 9,
        "Roberto" => 10,
        "Maripili" => 4
    ];

    $aprobados = 0;
   
?>

<!DOCTYPE html>
<html lang="en">
<!-- Un-Minified version -->
<link rel="stylesheet" href="https://cdn.simplecss.org/simple.css">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Lista notas</h1>
    <p>Alumnos con sus notas correspondientes</p>
    <table>
    <?php
     foreach($estudiantes as $nombre => $nota){
        echo "<tr>
                <td>$nombre</td>
                <td>$nota</td>
            </tr>";

        if($nota >= 5 ){
        $aprobados++;
     }
    }
    ?>
    </table>
    <p class="notice"> Hay <?= $aprobados; ?> aprobados </p>
    
</body>
</html>