<?php
session_start();
// cargar la configuracion flobal de rutas app root
require_once 'includes/config.php';

// cargar el modelo usando la constante de rta absoluta
require_once APP_ROOT . '/models/IncidenciaModel.php';


if (!isset($_SESSION['usuario'])) {
    header("location: login.php");
    exit();
}

$id = htmlspecialchars(trim($_GET['id']??''));

if(empty($id)){
    header("location: index.php");
    exit();
}

// logica del controlador
$incidenciasModel = new IncidenciaModel();
$estado = $incidenciasModel->recogerEstado($id);
if($estado = "Resuelta"){
    $cambio = "Pendiente";
    $cambiarEstado = $incidenciasModel->cambiarEstado($id , $cambio);
}elseif($estado = "En curso"){
    $cambio = "Resuelta";
    $cambiarEstado = $incidenciasModel->cambiarEstado($id , $cambio);
}elseif($estado = "Pendiente"){
    $cambio = "En curso";
    $cambiarEstado = $incidenciasModel->cambiarEstado($id , $cambio);
}


// mensaje 
if($cambiarEstado){
    $mensaje = "Incidencia cambiada correctamente";
    $tipo_mensaje = "success";
}else{
    $mensaje = "Incidencia no cambiada ";
    $tipo_mensaje = "error";
}


$_SESSION['mensaje'] = [
    "mensaje" => $mensaje,
    "tipo" => $tipo_mensaje
];
    header("location: index.php");
    exit();

