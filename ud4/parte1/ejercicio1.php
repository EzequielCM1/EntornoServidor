<?php
    $contador = 0;
    //comprobamos que existe el contador 
    if(isset($_COOKIE['contador'])){
        $contador =$_COOKIE['contador'];
    }
    //aumento su valor 
    $contador ++;
    // almacenamos una cookies  con el valor del contador
    setcookie('contador', $contador,time()+3600);//1 hora

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Cookies Contador</title>
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css" />
</head>

<body>
    <header>
        <h1>Cookies Contador</h1>
    </header>

    <main>
        
    <p class="notice">Contador : <?= $contador?></p>

    </main>

    <footer>
        <p>Zequi</p>
    </footer>
</body>

</html>