<?php
$fondo = "";
$fuente = "";
$estilo = "";
$mensaje = "";
$estiloFrase = [
    'poetico' => [
        "El viento susurra secretos al atardecer.",
        "Las estrellas lloran luz sobre la noche.",
        "Tu ausencia es un eco en mi alma."
    ],
    'literario' => [
        "Era el mejor de los tiempos, era el peor de los tiempos.",
        "En un lugar de la Mancha, de cuyo nombre no quiero acordarme.",
        "La soledad era un bosque que crecía dentro de él."
    ],
    'narrativo' => [
        "Juan abrió la puerta y supo que todo había cambiado.",
        "Ella caminó sin mirar atrás, dejando todo en silencio.",
        "El reloj marcó la hora exacta en que todo comenzó."
    ]
];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $fondo = htmlspecialchars($_POST['fondo'])??'';
    $fuente = htmlspecialchars($_POST['fuente'])??'';
    $estilo = htmlspecialchars(trim($_POST['estilo']))?? '';

    function tema (){
        // $mensaje ='<p style="background-color: '$fondo;'">';

       // $mensaje .="</p>";
    }


}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple.css">
</head>

<body>
    <h1>Cambiar Tema</h1>

    <form method="POST">
        <label for="fondo">Color de fondo</label>
        <select name="fondo" id="fondo">
            <option value="rojo">rojo</option>
            <option value="azul">azul</option>
            <option value="verde">verde</option>
        </select>
        <label for="fuente">Fuente</label>
        <select name="fuente" id="fuente">
            <option value="arial">arial</option>
            <option value="verdana">verdana</option>
            <option value="courier">courier</option>
        </select>
        <label for="estilo">estilo</label>
        <select name="estilo" id="estilo">
            <option value="narrativo">narrativo</option>
            <option value="poetico">poetico</option>
            <option value="literario">literario</option>
        </select>

        <input type="submit" value="convertir">
    </form>
    <p style="background-color: red;"></p>
    <div id="mostrar"></div>
</body>

</html>