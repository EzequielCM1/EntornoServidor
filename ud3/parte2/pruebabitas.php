<?php
    $nombre = $_GET['nombre'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css">
    
    <title>Document</title>
</head>
<body>
    <header>
        <h2>Hola</h2>
    </header>
    <a href="pruebabitas.php?nombre=Ezequiel&apellido=Campos">Mostrar</a>
    <pre>
        <?php
            echo "<h2>Bienvenido $nombre</h2>";
        ?>
        </pre>
        
</main>
</body>
</html>