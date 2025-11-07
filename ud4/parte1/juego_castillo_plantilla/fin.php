<?php

    session_start();
    $usuario = $_SESSION['usuario']?? "";

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
        <p>Has conseguido un total de 20 puntos.</p>
        <p>Has acertado 3 pases y fallado 2.</p>
            <button type="submit" name="reiniciar" >Jugar de nuevo</button>

        <p class="ok">Puntuación almacenada correctamente.</p>
    </main>
</body>

</html>