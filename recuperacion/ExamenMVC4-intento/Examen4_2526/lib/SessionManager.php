<?php

namespace Ezequiel\Lib;

use Ezequiel\App\models\LoginModel;

class SessionManager
{

    static public function iniciarSession(): void
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    static public function set($clave, $valor)
    {
        self::iniciarSession();
        $_SESSION[$clave] = $valor;
    }

    static public function get($clave)
    {
        self::iniciarSession();
        return $_SESSION[$clave] ?? null;
    }

    static public function eliminar($clave)
    {
        self::iniciarSession();
        if (isset($_SESSION[$clave])) {
            unset($_SESSION[$clave]);
        }
    }

    static public function estaAutenticado($clave): bool
    {
        self::iniciarSession();
        return isset($_SESSION[$clave]);
    }
    static public function comprobarSession($clave): bool
    {
        SessionManager::iniciarSession();
        if (isset($_SESSION[$clave])) {
            return true;
        } else {
            return false;
        }
    }
    static public function logout()
    {
        SessionManager::iniciarSession();
        session_unset();
        session_destroy();
    }
    static public function crearSession($codigo)
    {
        SessionManager::iniciarSession();

        $loginModel = new LoginModel();
        $userData = $loginModel->recogerDatosUsuario($codigo);

        $_SESSION['usuario'] = $userData;

        //como se crea sesion muestro el mensaje 
        $_SESSION['flash_message'] = "Usuario logueado correctamente";
    }
    static public function mensajeFlash($mensaje)
    {
        SessionManager::iniciarSession();
        $_SESSION['flash_message']  = $mensaje;
    }
    static public function mensajeTipo($mensaje, $tipo_mensaje)
    {
        SessionManager::iniciarSession();
        $_SESSION['mensaje'] = [
            "mensaje" => $mensaje,
            "tipo" => $tipo_mensaje
        ];
    }
}
