<?php 
/*Formulario donde el usuario introduce su nombre.
Al enviar, se guarda en $_SESSION['nombre'].
Se inicializa $_SESSION['puntos'] a 0 y $_SESSION['turno'] a 1.
Se redirige a juego.php*/
//inicializamos variables
$nombre='';
$error = '';
//iniciamos la sesión
session_start();

//SI ENVIAMOS EL formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //comprobamos que el nombre no viene vacío:
    $nombre=trim($_POST['nombre'])??'';
    //validamos que el nombre no esté vacío
    if ($nombre == '') {
        $error = 'Por favor, introduce un nombre.';
    } else {
        //almacenamos el nombre en la sesión y los puntos y turno
        $_SESSION['nombre'] = htmlspecialchars($nombre);
        $_SESSION['puntos'] = 0;
        $_SESSION['turno'] = 1;
        //redireccionamos a juego.php
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
    <form method="post">
        <label>Tu nombre:</label>
        <input type="text" name="nombre">
        <button type="submit">Entrar en servicio</button>
    </form>
    <?php
    if ($error != '') {
        echo "<p class='error'>$error</p>";
    }
    ?>
</body>
</html>
