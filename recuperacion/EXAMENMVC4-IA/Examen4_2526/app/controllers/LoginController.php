<?php

namespace Ezequiel\App\controllers;

use Ezequiel\App\controllers\Controller;
use Ezequiel\App\models\LoginModel;
use Ezequiel\Lib\SessionManager;


class LoginController extends Controller
{

    public static function index()
    {

        if (SessionManager::comprobarSession("usuario")) {
            header("Location: " . BASE_URL);
            exit();
        }
        $mensaje = $_SESSION['flash_message'] ?? '';
        unset($_SESSION['flash_message']);
        self::view("login_view", ["mensaje" => $mensaje]);
    }
    public static function comprobarUsuario()
    {
        SessionManager::iniciarSession();
        $errores = [];
        $mensaje = $_SESSION['flash_message'] ?? '';
        unset($_SESSION['flash_message']);

        // echo password_hash($contrasenia, PASSWORD_DEFAULT);

        $creadencial = htmlspecialchars(trim($_POST['credencial'] ?? ''));


        if (empty($creadencial)) {
            $errores['credencial'] = "La credenciales no puede estar vacia";
        }
        if (str_contains($creadencial, "-")) {
            if (substr_count($creadencial, "-") <= 1) {
                $division = explode("-", $creadencial);
                $codigo = $division[0];
                $pin = $division[1];
            } else {
                $errores['credencial'] = "Credencial incorrecta";
            }
        } else {
            $errores['credencial'] = "Credencial incorrecta";
        }


        if (empty($errores)) {

            $loginModel = new LoginModel();

            $resultado = $loginModel->buscarCodigoPin($codigo, $pin);
            if ($resultado) {
                $mensaje = "Usuario logueado correctamente";
                $tipo_mensaje = "flash-success";
                SessionManager::mensajeTipo($mensaje, $tipo_mensaje);
                SessionManager::crearSession($codigo);
                header("Location: " . BASE_URL);
                exit();
            } else {
                $mensaje = "Usuario y contraseña incorrectos"; 
                SessionManager::mensajeFlash($mensaje);
            }
        }
        // }
        self::view("login_view", ["errores" => $errores, "mensaje" => $mensaje, "credencial"=>$creadencial]);
    }
    public static function logout (){

    SessionManager::logout();
        header("Location: " . BASE_URL);
                exit();
    }
}
