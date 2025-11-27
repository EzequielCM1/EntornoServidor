<?php
    //inicializamos la sesión
    session_start();
    
    //destruimos todas las variables de sesión
    session_unset();
    session_destroy();

    //redirigimos al login
    header("Location: login.php");
    exit();
?>
