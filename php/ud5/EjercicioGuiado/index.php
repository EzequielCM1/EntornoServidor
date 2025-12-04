<?php
session_start();
if(empty($_SESSION['usuario'])){
    header("Location: login.php");
    exit();
}else{
    $mensajelogin = $_SESSION['flash_message'] ?? '';
    unset($_SESSION['flash_message']);
}



// cargar la configuracion flobal de rutas app root
require_once 'includes/config.php';

// cargar el modelo usando la constante de rta absoluta
require_once APP_ROOT . '/models/ProductosModel.php';

// logica del controlador
$productosModel = new ProductosModel();
$mensaje = null;
$tipo_mensaje = "";

// insertamos un producto nuevo
// esto en una app real iria en un if post

// $filas = $productosModel->createProducto("Raton OPtico", "1200 dpi con cable", 12.50);

// if($filas){
//     $mensaje = "Productos insertado correctamente";
//     $tipo_mensaje = "exito";
// }else{
//     $mensaje = "Error al insertar producto";
//     $tipo_mensaje = "error";
// }


//obtener datos para pasarlo a la vista
$lista_productos = $productosModel->obtenerTodos();

//cargar la vista 
require_once APP_ROOT . '/views/index_view.php';