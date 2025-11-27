<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

$nombre = $_SESSION['usuario'];

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $pregunta1 = htmlspecialchars(trim($_POST['pregunta1'] ?? ''));

    $_SESSION['preguntas']['p1'] = $pregunta1;
    header("Location: p2.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pregunta 1</title>
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css">
</head>

<body>
<header><h1>Encuesta</h1></header>

<main>
    <h3>Bienvenid@ <?= $nombre ?></h3>

    <form method="post">
        <h4>¿Plutón es un planeta?</h4>

        <label><input type="radio" name="pregunta1" value="si"> Sí</label>
        <label><input type="radio" name="pregunta1" value="no"> No</label>

        <button type="submit">Siguiente</button>
    </form>
</main>

<footer><p>Zequi</p></footer>
</body>
</html>
