<?php
      $mensaje = "";
      $temperatura;

    if ($_SERVER['REQUEST_METHOD'] == "GET") {
        // Recuperamos 
        $temperatura = $_GET['temperatura'] ?? '';

        // Validamos 
        if (empty($temperatura)) {
            $mensaje = "<p>La temperatura es obligatoria</p>";
        } else {
            $celsius = floatval($temperatura);

            $formula = ($celsius * 9 / 5) + 32;

            $mensaje = "<h2>Resultado:</h2>";
            $mensaje .= "<p>$celsius °C = $formula °F</p>";
        }
    }
   
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' href='https://cdn.simplecss.org/simple.min.css'>
    <title>Document</title>
</head>

<body>
    <h1>Midamos la temperatura</h1>
    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="GET">

        <label for="temperatura">Temperatura</label>
        <input type="number" name="temperatura" id="temperatura" placeholder="temperatura">
        <button type="submit" name="enviar">Enviar</button>
        <button type="reset">Limpiar</button>
    </form>
    <pre>
    <?php
         echo $mensaje;
    ?>
    </pre>
</body>

</html>