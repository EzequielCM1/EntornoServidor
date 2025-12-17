<?php
session_start();
// cargar la configuracion flobal de rutas app root
require_once 'includes/config.php';

// cargar el modelo usando la constante de rta absoluta
require_once APP_ROOT . '/models/IncidenciaModel.php';

// si esta logueado
if (!isset($_SESSION['usuario'])) {
    header("location: login.php");
    exit();
}

//variable
$id = htmlspecialchars(trim($_GET['id']??''));

if(empty($id)){// si no hay id te saque 
    header("location: index.php");
    exit();
}

// logica del controlador
$incidenciasModel = new IncidenciaModel();
$borrado = $incidenciasModel->borrarIncidencia($id);

if($borrado){
    $mensaje = "Incidencia borrado correctamente";
    $tipo_mensaje = "success";
}else{
    $mensaje = "Incidencia no borrado ";
    $tipo_mensaje = "error";
}

$_SESSION['mensaje'] = [
    "mensaje" => $mensaje,
    "tipo" => $tipo_mensaje
];

    header("location: index.php");
    exit();

