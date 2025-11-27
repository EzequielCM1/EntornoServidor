<?php

session_start();
$usuario = $_SESSION['usuario'] ?? "";

if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

// Recuperar datos de la sesión
$usuario  = $_SESSION['usuario'];
$puntos   = $_SESSION['puntos'];
$aciertos = $_SESSION['aciertos'];
$fallos   = $_SESSION['fallos'];

// Guardar en registro.txt
$fecha = date("Y-m-d");
$linea = "$usuario - $puntos puntos - $aciertos aciertos - $fecha" . PHP_EOL;

file_put_contents("registro.txt", $linea, FILE_APPEND);


if (isset($_POST['reiniciar'])) {
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit();
}


?>
<!DOCTYPE html>
<html lang='es'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>

    <head>
        <meta charset="UTF-8">
        <title>Guardia del Castillo</title>
        <link rel='stylesheet' href='css/estilos.css'>
    </head>

<body>
    <h1>Guardia del Castillo</h1>
    <main>
        <p>Gracias por jugar, <?= $usuario ?>.</p>
        <p>Has conseguido un total de <?= $_SESSION['puntos'] ?> puntos.</p>
        <p>Has acertado <?= $_SESSION['aciertos'] ?> pases y fallado <?= $_SESSION['fallos'] ?>.</p>
        <form action="" method="post">
            <button type="submit" name="reiniciar">Jugar de nuevo</button>
        </form>
        

        <p class="ok">Puntuación almacenada correctamente.</p>
    </main>
</body>

</html>