<?php
    session_start();
    $usuario = "";
    $errores = [];

    if(isset($_SESSION['usuario'])){
        header("Location: juego.php");
        exit();
    }


    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $usuario = htmlentities(trim($_POST['usuario']??''));

        if($usuario === ""){
            $errores['usuario']= "Introduce un nombre";
        }

        if(empty($errores)){
            $_SESSION['usuario'] = $usuario;
            header("Location: juego.php");
            exit();
        }
    }

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>titulo</title>
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css" />
    <style>
    .error{
        color: red;
    }
        
        </style>
</head>

<body>
    <header>
        <h1>Puertas del Castillo </h1>
    </header>

    <main>
        <form action="" method="POST">
            <h3>Introduce tu usuario</h3>
            <label for="name">Usuario:</label>
            <input type="text" id="usuario" name="usuario" /><br>
            <?php if(!empty($errores['usuario'])):?>
            <span class="error"><?= $errores['usuario'] ?></span>
            <?php endif ;?><br>
            <button type="submit" name="enviar">Enviar</button>
        </form>
    </main>

    <footer>
        <p>Zequi</p>
    </footer>
</body>

</html>