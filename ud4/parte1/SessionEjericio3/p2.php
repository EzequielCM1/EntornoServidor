<?php
session_start();

if (!isset($_SESSION['usuario']) || !isset($_SESSION['preguntas']['p1'])) {
    header("Location: index.php");
    exit();
}

$nombre = $_SESSION['usuario'];

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $pregunta2 = htmlspecialchars(trim($_POST['pregunta2'] ?? ''));

    $_SESSION['preguntas']['p2'] = $pregunta2;
    header("Location: p3.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pregunta 2</title>
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css">
</head>

<body>
<header><h1>Encuesta</h1></header>

<main>
    <h3>Hola nuevamente, <?= $nombre ?></h3>

    <form method="post">
        <h4>¿La Tierra es plana?</h4>

        <label><input type="radio" name="pregunta2" value="si"> Sí</label>
        <label><input type="radio" name="pregunta2" value="no"> No</label>

        <button type="submit">Siguiente</button>
    </form>
</main>

<footer><p>Zequi</p></footer>
</body>
</html>
