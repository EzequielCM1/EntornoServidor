<?php
$rutaJson = "preguntas.json";
$json = file_get_contents($rutaJson);
$todaspreguntas = json_decode($json, true);
$mensaje = "";

///////
$preguntasAleatorias = array_rand($todaspreguntas, 3);
    $trespreguntas = [];
    foreach ($preguntasAleatorias as $pregunta) {
        $trespreguntas[] = $todaspreguntas[$pregunta];
    }
/////
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Pregunta1 = $_POST['Pregunta0'];
    $Pregunta2 = $_POST['Pregunta1'];
    $Pregunta3 = $_POST['Pregunta2'];

    $Respuestas = [$Pregunta1, $Pregunta2 , $Pregunta3];

    echo print_r($Respuestas);
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