<?php

session_start();
// cargar la configuracion flobal de rutas app root
require_once 'includes/config.php';

// cargar el modelo usando la constante de rta absoluta
require_once APP_ROOT . '/models/IncidenciaModel.php';


if(!isset($_SESSION['usuario'])){
    header("location: login.php");
    exit();
}
// Mensaje

$mensaje = null;
$tipo_mensaje = "";

if(isset($_SESSION['mensaje'])){
    $mensaje = $_SESSION['mensaje']['mensaje'];
    $tipo_mensaje = $_SESSION['mensaje']['tipo'];
    unset($_SESSION['mensaje']);
}

// logica del controlador
$incidenciasModel = new IncidenciaModel();
$incidencias = $incidenciasModel->obtenerTodos();


//Estadisticas basica
$totalTicket = 0;
$mediaticket = 0;
$totalHoras = 0;


// incluimos el html
require_once APP_ROOT . '/views/index_view.php';