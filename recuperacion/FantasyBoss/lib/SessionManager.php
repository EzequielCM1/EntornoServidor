<?php

namespace Ezequiel\Lib;

class SessionManager {

    public static function iniciarSesion() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function destruirSesion() {
        session_unset();
        session_destroy();
    }

    public static function estaAutentificado($manager) {
        return isset($manager);
    }

    public static function crearMensajeFlash($tipo, $mensaje) {
        $_SESSION[$tipo] = $mensaje;
    }
}
