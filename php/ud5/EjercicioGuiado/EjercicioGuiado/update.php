<?php

session_start();
require_once 'includes/config.php';
require_once APP_ROOT . '/models/ProductosModel.php';

if (empty($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

$rolUsuario = $_SESSION['rol'] ?? '';

if ($rolUsuario !== "admin") {
    header("Location: login.php");
    exit();
} elseif ($rolUsuario == "") {
    header("Location: login.php");
    exit();
}

$id = htmlspecialchars(trim($_GET['id'] ?? ''));

if (empty($id)) {
    header("Location: index.php");
    exit();
}

$productosModel = new ProductosModel();
$mensaje = null;
$tipo_mensaje = "";

$datos = $productosModel->buscarId($id);
if (empty($datos)) {
    $_SESSION['mensaje'] = [
        "mensaje" => "No se ha encontrado el producto",
        "tipo" => "error"
    ];
    header("Location: index.php");
    exit();
}
$fila = $datos[0];


$nombre = "";
$descripcion = "";
$precio = 0;
$errores = [];
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $nombre = htmlspecialchars(trim($_POST['name'] ?? ''));
    $descripcion = htmlspecialchars(trim($_POST['description'] ?? ''));
    $precio = htmlspecialchars(trim($_POST['price']));

    if ($nombre == "") {
        $errores["nombre"] = "El nombre no puede estar vacio";
    }

    if (empty($errores)) {

        $filas = $productosModel->actualizarProductos($nombre, $descripcion, $precio, $id);

        if ($filas) {
            $mensaje = "Producto actualizado correctamente";
            $tipo_mensaje = "exito";
        } else {
            $mensaje = "Productos no actualizado correctamente";
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

require_once APP_ROOT . '/views/update_view.php';
