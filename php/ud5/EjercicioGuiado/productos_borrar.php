<?php

session_start();
require_once 'includes/config.php';
require_once APP_ROOT . '/models/ProductosModel.php';

if(empty($_SESSION['usuario'])){
    header("Location: login.php");
    exit();
}

$id = htmlspecialchars(trim($_GET['id']??''));

if(empty($id)){
    header("Location: index.php");
    exit();
}

$productosModel = new ProductosModel();
$mensaje = null;
$tipo_mensaje = "";

$filas = $productosModel->borrarProductos($id);

if($filas){
    $mensaje = "Productos borrado correctamente";
    $tipo_mensaje = "exito";
}else{
    $mensaje = "Productos no borrado correctamente";
    $tipo_mensaje = "error";
}

$_SESSION['mensaje'] = [
    "mensaje" => $mensaje,
    "tipo" => $tipo_mensaje
];
header("Location: index.php");
    exit();
