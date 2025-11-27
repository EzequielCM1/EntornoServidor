<?php
session_start();

if (!isset($_SESSION['usuario']) || !isset($_SESSION['preguntas']['p2'])) {
    header("Location: index.php");
    exit();
}

$nombre = $_SESSION['usuario'];

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $pregunta3 = htmlspecialchars(trim($_POST['pregunta3'] ?? ''));

    $_SESSION['preguntas']['p3'] = $pregunta3;
    header("Location: resultado.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pregunta 3</title>
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css">
</head>

<body>
<header><h1>Encuesta</h1></header>

<main>
    <h3>Última pregunta, <?= $nombre ?></h3>

    <form method="post">
        <h4>¿El Sol es una estrella?</h4>

        <label><input type="radio" name="pregunta3" value="si"> Sí</label>
        <label><input type="radio" name="pregunta3" value="no"> No</label>

        <button type="submit">Ver resultados</button>
    </form>
</main>

<footer><p>Zequi</p></footer>
</body>
</html>
