<?php
session_start();

if (!isset($_SESSION['usuario']) || !isset($_SESSION['preguntas']['p3'])) {
    header("Location: index.php");
    exit();
}

$nombre = $_SESSION['usuario'];

// Respuestas correctas:
$correctas = [
    'p1' => 'no',  // Plutón no es un planeta
    'p2' => 'no',  // La tierra no es plana
    'p3' => 'si',  // El Sol es una estrella
];

$respuestas = $_SESSION['preguntas'];
$aciertos = 0;

foreach ($correctas as $preg => $valorCorreto) {
    if (isset($respuestas[$preg]) && $respuestas[$preg] === $valorCorreto) {
        $aciertos++;
    }
}

$puntaje = round(($aciertos / 3) * 100);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultados</title>
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css">
</head>

<body>
<header><h1>Resultados de <?= $nombre ?></h1></header>

<main>
    <p>Aciertos: <strong><?= $aciertos ?>/3</strong></p>
    <p>Puntaje final: <strong><?= $puntaje ?>%</strong></p>

    <a href="index.php"><button>Reiniciar encuesta</button></a>
</main>

<footer><p>Zequi</p></footer>
</body>
</html>
