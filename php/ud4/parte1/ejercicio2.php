<?php
    $color = "";
    if(isset($_COOKIE['color'])){
        $color = $_COOKIE['color'];
    }
    
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        
        $color = $_POST['color']??'';
        
    setcookie('color', $color, time()+3600);
    header("Location: ejercicio2.php");
    exit();
    }
    
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>cookies</title>
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css" />
    <style>
        body{
            background-color: <?php echo $color?>;
        }
    </style>
</head>

<body>
    <header>
        <h1>Color fondo Cookies</h1>
    </header>

    <main>
        <form action="" method="POST">
        <p class="notice">Elige el color de fondo : <br><br><input type="color" name="color"><br></p>
        <button type="submit" value="enviar">Enviar</button>
        </form> 
    </main>

    <footer>
        <p>Zequi</p>
    </footer>
</body>

</html>