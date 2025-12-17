<?php
session_start();

if (isset($_SESSION['usuario'])) {
    header("Location: index.php", true, 303);
    exit();
}
//incluimos los includes necesarios 
require_once 'includes/config.php';

$errores = [];
$mensaje = $_SESSION['flash_message']??'';
unset($_SESSION['flash_message']);

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $nombre = htmlspecialchars(trim($_POST['username'] ?? ''));
    $contrasenia = trim($_POST['password'] ?? '');

    if ($nombre == "") {
        $errores['nombre'] = "El nombre no puede estar vacio";
    }
    if (empty($contrasenia)) {
        $errores['password'] = "La contraseña no puede estar vacia";
    }
    echo password_hash($contrasenia,PASSWORD_DEFAULT);

    if (empty($errores)) {
        require_once 'models/LoginModel.php';
        $loginModel = new LoginModel();

        $resultado = $loginModel->buscarUsuario($nombre, $contrasenia);
        if ($resultado) {

            $rol = $loginModel->comprobarRol($nombre);
            
            $_SESSION['rol'] = $rol;

            $_SESSION['flash_message'] = "Usuario logueado correctamente";
            $_SESSION['usuario'] = $nombre;
            header("location: index.php");
            exit();
        }else{
            $_SESSION['flash_message']  = "Usuario y contraseña incorrectos";
        }
    }
}



// incluimos el html
require_once APP_ROOT . '/views/login_view.php';
