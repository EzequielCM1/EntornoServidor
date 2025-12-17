<?php

session_start();
require_once 'includes/config.php';
require_once 'models/loginModel.php';

if (isset($_SESSION['usuario'])) {
    header("Location: index.php", true, 303);
    exit();
}

$nombre = "";
$password = "";
$errores = [];
$mensaje = $_SESSION['flash_message'] ?? '';
unset($_SESSION['flash_message']);
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $nombre = htmlspecialchars(trim($_POST['usuario'] ?? ''));
    $password = trim($_POST['password'] ?? '');

    if ($nombre == "") {
        $errores['nombre'] = "El nombre no puede estar vacio";
    }
    if (empty($password)) {
        $errores['password'] = "La contraseña no puede estar vacia";
    }

    if (empty($errores)) {

        $loginModel = new LoginModel();

        $resultado = $loginModel->buscarUsuario($nombre, $password);
        if ($resultado) {

            $_SESSION['flash_message'] = "Usuario logueado correctamente";
            $_SESSION['usuario'] = $nombre;
            header("location: index.php");
            exit();
        } else {
            $_SESSION['flash_message']  = "Usuario y contraseña incorrectos";
        }
    }
}

// incluimos el html
require_once APP_ROOT . '/views/login_view.php';
