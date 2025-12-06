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
    $passwordHash =  password_hash($contrasenia,PASSWORD_DEFAULT);

    if (empty($errores)) {
        require_once 'models/LoginModel.php';
        $loginModel = new LoginModel();

        $resultado = $loginModel->buscarUsuario($nombre, $contrasenia);
        if ($resultado) {
            $_SESSION['flash_message'] = "Usuario ya existe";
            header("location: registrar.php");
            exit();
        }

        $registrado = $loginModel->registrarUsuario($nombre, trim($passwordHash));
        if($registrado){
            $rol = $loginModel->comprobarRol($nombre);  
            $_SESSION['rol'] = $rol;

            $_SESSION['flash_message'] = "Te has registrado correctamente";
            $_SESSION['usuario'] = $nombre;
            header("location: index.php");
            exit();
        }
    }
}



// incluimos el html
require_once APP_ROOT . '/views/registrar_view.php';
