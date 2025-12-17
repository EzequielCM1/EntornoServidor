<?php

session_start();

// destruimos las variables de la siseion
session_unset();
session_destroy();

$_SESSION['mensaje'] = [
    "mensaje" => "Se ha cerrado session",
    "tipo" => "exito"
];


// redirigimos al login
header("Location: login.php");
exit();
