<?php
session_start();

define('APP_ROOT', dirname(__DIR__));

$p = $_GET['p'] ?? "inicio";
$paginasPermitidas = ['inicio', 'nosotros', 'contacto'];

$mensaje = $_SESSION['flash_msg'] ?? null;
if ($mensaje) {
    unset($_SESSION['flash_msg']);
}

if (in_array($p, $paginasPermitidas)) {


    if ($_SERVER['REQUEST_METHOD'] = "POST" && isset($_POST['enviar'])) {

        $nombre = htmlspecialchars(trim($_POST['nombre'] ?? ''));
        $mensaje = htmlspecialchars(trim($_POST['mensaje'] ?? ''));

        if (!empty($nombre)) {
            $_SESSION['flash_msg'] = "Gracias $nombre, hemos recibido tu mensaje ";
            header('Location: index.php');
            exit();
        } else {
            $_SESSION['flash_msg'] = "El nombre no puede estar vacio ";
            header('Location: index.php?p=contacto');
            exit();
        }
    }
    include APP_ROOT . '/includes/header.php';
    include APP_ROOT . "/views/{$p}.php";
    include APP_ROOT . '/includes/footer.php';
} else {
    header("HTTP/1.0 404 Not Found");
    $p = "404";
    include APP_ROOT . "/views/{$p}.php";
}




