<?php

session_start();
require_once 'includes/config.php';
require_once APP_ROOT . '/models/ProductosModel.php';

if (empty($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

$rolUsuario = $_SESSION['rol'] ?? '';

if($rolUsuario != "admin"){
    header("Location: index.php");
    exit();
}elseif($rolUsuario == ""){
    header("Location: index.php");
    exit();
}

$productosModel = new ProductosModel();
$mensaje = null;
$tipo_mensaje = "";

$errores = [];
$nombre = "";
$descripcion = "";
$precio = null;
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $nombre = htmlspecialchars(trim($_POST['name'] ?? ''));
    $descripcion = htmlspecialchars(trim($_POST['description'] ?? ''));
    $precio = htmlspecialchars(trim($_POST['price']));

    if ($nombre == "") {
        $errores["nombre"] = "El nombre no puede estar vacio";
    }
    if ($descripcion == "") {
        $errores["descripcion"] = "La descripcion no puede estar vacio";
    }
    if ($precio == 0) {
        $errores["precio"] = "Debes ponerle un precio ";
    }

    if (empty($errores)) {

        // insertamos un producto nuevo
        // esto en una app real iria en un if post

        $filas = $productosModel->createProducto($nombre, $descripcion, $precio);

        if($filas){
            $mensaje = "Productos insertado correctamente";
            $tipo_mensaje = "exito";
        }else{
            $mensaje = "Error al insertar producto";
            $tipo_mensaje = "error";
        }

        $_SESSION['mensaje'] = [
            "mensaje" => $mensaje,
            "tipo" => $tipo_mensaje
        ];

        header("Location: index.php");
            exit();
    }
}

require_once APP_ROOT . '/views/insert_view.php';
