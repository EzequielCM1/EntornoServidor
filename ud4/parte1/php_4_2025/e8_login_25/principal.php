<?php
    //iniciamos la sesión
    session_start();

    //autentificación de sesión
    if (!isset($_SESSION['usuario'])){
        //si no existe la variable de sesión del usuario
        header("Location: login.php");
        exit();
    }
    $usuario = $_SESSION['usuario'];
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
    <header><h2>Página Principal</h2></header>
    <main>
        
        <!-- código php -->
        <p class='notice'>Bienvenido <?=htmlspecialchars($usuario);?><br>
    <a href="logout.php">Logout</a></p>
        
    </main>
    <footer><p>P.Lluyot</p></footer>
</body>
</html>