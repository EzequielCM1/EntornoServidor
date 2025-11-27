<?php
    session_start();
    $usuario = "";
    $ronda = 0;
    $puntos = 0;
    $aciertos = 0;
    $fallos = 0;
    $errores = [];

    if(isset($_SESSION['usuario'])){
        header("Location: juego.php");
        exit();
    }


    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $usuario = htmlentities(trim($_POST['nombre']??''));

        if($usuario === ""){
            $errores['usuario']= "Introduce un nombre";
        }

        if(empty($errores)){
            $_SESSION['usuario'] = $usuario;
            $_SESSION['ronda'] = $ronda;
            $_SESSION['puntos'] = $puntos;
            $_SESSION['aciertos'] = $aciertos;
            $_SESSION['fallos'] = $fallos;
            header("Location: juego.php");
            exit();
        }
    }
?>

<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"><title>Guardia del Castillo</title>
<link rel='stylesheet' href='css/estilos.css'>

</head>

<body>
    <h1>Bienvenido a las Puertas del Castillo</h1>
    <form action="" method="POST">
        <label>Tu nombre:</label>
        <input type="text" name="nombre">
        <button type="submit">Entrar en servicio</button>
    </form>
    <p class='error'><?= $errores['usuario']??'' ?></p>
    
</body>
</html>
