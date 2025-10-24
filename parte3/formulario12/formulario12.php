<?php
$rutaJson = "preguntas.json";
$json = file_get_contents($rutaJson);
$todaspreguntas = json_decode($json, true);
$mensaje = "";

///////
$ficheroRespuestas = "respuestas.txt"; // donde se guarda las respuestas correctas
/////
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $respuestasCorrectas = json_decode(file_get_contents($ficheroRespuestas), true);

    $respuestasUsuario = [
    $_POST['Pregunta0']??'',
    $_POST['Pregunta1']??'',
    $_POST['Pregunta2']??''
    ];

    ///comprobar las respuestas 
    $correctasNum = 0;
    $resultado = "";
    foreach ($respuestasUsuario as $i => $respuestaUsuario) {
        $respuestaCorrecta = $respuestasCorrectas[$i];

        if ($respuestaUsuario === $respuestaCorrecta) {
            $resultado .= "Pregunta " . ($i + 1) . ": Correcta (" . htmlspecialchars($respuestaUsuario) . ")<br>";
            $correctasNum++;
        } else {
            $resultado .= "Pregunta " . ($i + 1) . ": Incorrecta. Tu respuesta: " 
                        . htmlspecialchars($respuestaUsuario)
                        . " | Correcta: " . htmlspecialchars($respuestaCorrecta) . "<br>";
        }
    }
    $mensaje = "Has acertado $correctasNum de 3 preguntas.<br><br>$resultado";


    
}else{
    $preguntasAleatorias = array_rand($todaspreguntas, 3);
    $trespreguntas = [];
    $respuestasCorrectas = [];
    foreach ($preguntasAleatorias as $pregunta) {
        $trespreguntas[] = $todaspreguntas[$pregunta];
         $respuestasCorrectas[] = $todaspreguntas[$pregunta]['respuesta_correcta'];
    }
     file_put_contents($ficheroRespuestas, json_encode($respuestasCorrectas));
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Subida de archivo con palabras</title>
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css" />
</head>

<body>
    <header>
        <h1>Subida de archivo con palabras</h1>
    </header>

    <main>


        <form action="" method="POST">
            <?php
            $contador = 0;
            foreach ($trespreguntas as $a) {
                echo  "<p>";

                echo htmlspecialchars($a['pregunta']);
                echo "<br><br>";
                
                foreach ($a['opciones'] as $b) {

                    echo '<input type="radio" name="Pregunta' . $contador . '" value="' . $b . '" id="' . $b . '">';
                    echo '<label for="Pregunta' . $contador . '">' . $b . '</label><br>';
                    
                }
                $contador++;
                
                echo  "</p>";
            }
            ?>
        <input type="submit" value="comprobar" name="comprobar">
        </form>

        <?php if ($mensaje) : ?>
            <p class="success"><?= $mensaje ?></p>
        <?php endif; ?>
    </main>

    <footer>
        <p>Zequi</p>
    </footer>
</body>

</html>