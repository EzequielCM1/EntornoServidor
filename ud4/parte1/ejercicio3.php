<?php
    $nombre = "";

    if(isset($_COOKIE['nombre'])){
        $nombre = $_COOKIE['nombre'];
    }
    
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        
        $nombre = $_POST['nombre']??'';
        
    setcookie('nombre', $nombre, time()+3600);
    header("Location: ejercicio3.php");
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
</head>

<body>
    <header>
        <h1>Nombre de usuario en cookies</h1>
    </header>

    <main>
        <?php if(empty($nombre)){?>
        <form action="" method="POST">
            <label for="nombre">Nombre :</label>
            <input type="text" name="nombre">
            <button type="submit" value="enviar">Enviar</button>
        </form>
        <?php }else{?>
            <p class="notice"> Hola <?= $nombre?></p>
        <?php }?>
    </main>

    <footer>
        <p>Zequi</p>
    </footer>
</body>

</html>