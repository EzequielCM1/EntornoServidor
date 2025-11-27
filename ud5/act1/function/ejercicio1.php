<?php
/*
$host = "localhost";
$user = "usuario_tienda";
$password = "1234";
$database = "tienda";
*/

// establecemos la conexion con la base de datos
function conectarBD($host, $user, $password, $database): mysqli
{
    $conexion = new mysqli($host, $user, $password, $database);

    if ($conexion->connect_error) {
        die("Error de conexion Fin!!!!");
    }

    return $conexion;
}

// no se te olvide siempre de cerrar 
function cerrarBD(mysqli $conexion): void
{
    if ($conexion) {
        $conexion->close();
    }
}


