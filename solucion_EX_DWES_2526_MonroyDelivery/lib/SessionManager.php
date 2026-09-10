<?php

/**
 * P.Lluyot-2025
 */

namespace Pepelluyot\Lib;

/**
 * Clase SessionManager para gestionar las sesiones de usuario de forma centralizada.
 * Proporciona métodos estáticos para iniciar, destruir, establecer, obtener y eliminar
 * variables de sesión, así como para verificar el estado de autenticación.
 */
class SessionManager
{
    /**
     * Inicia la sesión PHP si aún no está iniciada.
     * Es una buena práctica llamar a este método antes de interactuar con $_SESSION.
     *
     * @return void
     */
    public static function iniciarSesion()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Destruye completamente la sesión actual.
     * Elimina todas las variables de sesión y el ID de sesión.
     *
     * @return void
     */
    public static function destruirSesion()
    {
        // Iniciamos la sesión antes de destruirla
        self::iniciarSesion();

        if (session_status() != PHP_SESSION_NONE) {
            session_unset();   // Elimina todas las variables de la sesión
            session_destroy(); // Destruye los datos de la sesión en el servidor
        }
    }

    /**
     * Establece un valor en una variable de sesión.
     *
     * @param string $clave La clave de la variable de sesión.
     * @param mixed $valor El valor a almacenar.
     * @return void
     */
    public static function set($clave, $valor)
    {
        self::iniciarSesion();
        $_SESSION[$clave] = $valor;
    }

    /**
     * Obtiene el valor de una variable de sesión.
     *
     * @param string $clave La clave de la variable de sesión.
     * @return mixed|null El valor de la variable de sesión, o null si no existe.
     */
    public static function get($clave)
    {
        self::iniciarSesion();
        return isset($_SESSION[$clave]) ? $_SESSION[$clave] : null;
    }

    /**
     * Elimina una variable específica de la sesión.
     *
     * @param string $clave La clave de la variable de sesión a eliminar.
     * @return void
     */
    public static function eliminar($clave)
    {
        self::iniciarSesion();
        if (isset($_SESSION[$clave])) {
            unset($_SESSION[$clave]);
        }
    }

    /**
     * Comprueba si una variable de sesión específica existe, lo que puede indicar
     * si un usuario está "autenticado" o si un dato particular está presente.
     *
     * @param string $clave La clave de la variable de sesión a comprobar.
     * @return bool True si la variable de sesión existe, false en caso contrario.
     */
    public static function estaAutenticado($clave)
    {
        self::iniciarSesion();
        return isset($_SESSION[$clave]);
    }

    /**
     * Alias de estaAutenticado, comprueba si una variable de sesión existe.
     *
     * @param string $clave La clave de la variable de sesión a comprobar.
     * @return bool True si la variable de sesión existe, false en caso contrario.
     */
    public static function existe($clave)
    {
        self::iniciarSesion();
        return isset($_SESSION[$clave]);
    }
}
