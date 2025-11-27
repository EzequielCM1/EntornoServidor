<?php
session_start();
//código php para finalizar la partida
//Si no hay nombre en sesión, redirigimos a index.php
if (!isset($_SESSION['nombre'])) {
    header('Location: index.php', true, 303);
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reiniciar'])) {
    //Si el usuario quiere reiniciar, destruimos la sesión y redirigimos a index.php
    session_unset();
    session_destroy();
    header('Location: index.php', true, 303);
    exit;
}
$mensaje = "";
$estado='error';
//recuperamos la información de la sesión para guardar en un archivo
$nombre = $_SESSION['nombre'];
$puntos = $_SESSION['puntos'];
$aciertos = $_SESSION['aciertos'];
$fallos = $_SESSION['fallos'];
$turno = $_SESSION['turno']??1;

//comprobamos si hemos llegado al final, en otro caso volvemos a la página anterior
if ($turno <= 5){
    //redirigimos   
    header ("Location: juego.php", true, 302);
    exit();
}

//Guardamos los datos en un archivo de texto llamado "resultados.txt" con este formato: Clara - 35 puntos - 3 aciertos - 2025-04-24"
$linea = "$nombre - $puntos puntos - $aciertos aciertos - " . date('Y-m-d') . PHP_EOL;
$fichero = @fopen('registro.txt', 'a');
if ($fichero) {
    fwrite($fichero, $linea);
    fclose($fichero);
    $mensaje = "Puntuación almacenada correctamente.";
    $estado='correcto';
} else {
    $mensaje = "No se ha podido guardar la puntuación.";
    $estado='error';
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
        <p>Gracias por jugar, <?= htmlspecialchars($nombre) ?>.</p>
        <p>Has conseguido un total de <?= $puntos; ?> puntos.</p>
        <p>Has acertado <?= $aciertos; ?> pases y fallado <?= $fallos; ?>.</p>
        <form method="post" action="fin.php">
            <button type="submit" name="reiniciar" value="1">Jugar de nuevo</button>
        </form>
        <p <?= $estado === 'correcto' ? 'class="ok"' : 'class="error"' ?>><?= htmlspecialchars($mensaje) ?></p>
    </main>
</body>

</html>