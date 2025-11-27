<?php
    //código php
    $contador = 0;

    //comprobamos si existe una cookie contador
    if (isset($_COOKIE['contador']))
        $contador =$_COOKIE['contador'];

    //aumentamos el contador
    $contador ++;

    //almacenamos una cookie con el contador actual
    setcookie("contador",$contador, time()+ 3600); //1 hora

?>
<!DOCTYPE html>
<html lang='es'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>P.Lluyot</title>
    <link rel='stylesheet' href='https://cdn.simplecss.org/simple.min.css'>
</head>
<body>
    <header><h2></h2></header>
    <main>
        <p class='notice'>CONTADOR: <?=$contador;?></p>
    </main>
    <footer><p>P.Lluyot</p></footer>
</body>
</html>