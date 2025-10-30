<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' href='https://cdn.simplecss.org/simple.min.css'>
    <title>Document</title>
</head>

<body>
    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="GET">

        <label for="nombre">Nombre</label>
        <input type="text" name="nombre" id="nombre" , value="Nombre">
        <button type="submit" name="enviar">Enviar</button>

    </form>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        echo "<p>Hola " . $_POST['nombre'] . "</p>";
    }
    ?>

</body>

</html>