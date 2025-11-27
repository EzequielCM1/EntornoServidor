<?php
session_start();
require_once '../dataset.php';
require_once 'funciones_csv.php';   // ← AÑADIDO

if($_SERVER['REQUEST_METHOD'] == "GET"){
    $id = htmlspecialchars(trim($_GET['id']??0));

    if(empty($id) || !isset($viajes[$id])){
        header("Location: index.php");
        exit();
    }

    $viaje = $viajes[$id];
}

if(!isset($_SESSION['reservas'])){
    $_SESSION['reservas'] = [];
}

if(!in_array($id, $_SESSION['reservas'],true)){
    $_SESSION['reservas'][]= $id;

    // AÑADIR AL CSV 
    guardarReservaCSV($id, $viajes);
}

$_SESSION['flash_message'] = 'El viaje a '.$viaje['destino'].' ha sido reservado con exito';
header("Location: index.php");
exit();
?>
