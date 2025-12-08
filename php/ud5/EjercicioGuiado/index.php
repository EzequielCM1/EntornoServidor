<?php
session_start();

// cargar la configuracion flobal de rutas app root
require_once 'includes/config.php';

// cargar el modelo usando la constante de rta absoluta
require_once APP_ROOT . '/models/ProductosModel.php';


$mensajelogin ='';

if(empty($_SESSION['usuario'])){
    header("Location: login.php");
    exit();
}
if(isset($_SESSION['rol'])){
    $rol = $_SESSION['rol'];
}else{ // esto es inecesario ya que por defecto si o si te crea el ro usuario , pero por si las moscas 
    $_SESSION['flash_message'] = "No tienes nigun rol , algo salio mal";
    header("Location: login.php");
    exit();
}

if (isset($_SESSION['flash_message'])){
    $mensajelogin = $_SESSION['flash_message'] ;
    unset($_SESSION['flash_message']);
}


// logica del controlador
$productosModel = new ProductosModel();
$mensaje = null;
$tipo_mensaje = "";



if(isset($_SESSION['mensaje'])){
    $mensaje = $_SESSION['mensaje']['mensaje'];
    $tipo_mensaje = $_SESSION['mensaje']['tipo'];
    unset($_SESSION['mensaje']);
}

//obtener datos para pasarlo a la vista

$busqueda =trim( $_GET['buscar']??'');
if($busqueda !==""){
$lista_productos = $productosModel->buscarProductoNombre($busqueda);
}else{
$lista_productos = $productosModel->obtenerTodos();
}


//cargar la vista 
require_once APP_ROOT . '/views/index_view.php';