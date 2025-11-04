<?php
    $nombre = $_GET['nombre']??'';
    $ruta = "repaso1.txt";

    $usuarios = [];
    
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>titulo</title>
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css" />
</head>

<body>
    <header>
        <h1>Titulo</h1>
    </header>

    <main>
        <?php 
        echo "hola ".$nombre;
        ?>
    </main>

    <footer>
        <p>Zequi</p>
    </footer>
</body>

</html>