<?php

/**
 * P.Lluyot-2025
 */

namespace Pepelluyot\App\controllers;

use Pepelluyot\App\models\LoginModel;
use Pepelluyot\Lib\SessionManager;

class LoginController extends Controller
{
    public static function showLogin()
    {
        //si el usuario está autentificado redirigimos a home
        if (SessionManager::estaAutenticado('id_empleado')) {
            header('Location: ' . BASE_URL);
            exit();
        };
        //recuperamos el mensaje flash (por sesión o por GET)
        $mensaje = SessionManager::get('mensaje_flash') ?? null;
        SessionManager::eliminar('mensaje_flash');

        //lo eliminamos de la sesión para que no aparezca más
        SessionManager::eliminar('mensaje_flash');

        //llamamos a la vista de login,
        self::view('login_view', ['mensaje' => $mensaje]);
    }
    public static function authenticate()
    {
        //recuperamos los datos por post
        $credencial = htmlspecialchars(trim($_POST['credencial'])) ?? '';
        $codigo = $pin = '';
        //comprobamos que estén rellenos y que el pin es un número de 4 cifras.
        if ($credencial == '') {
            $errores['credencial'] = "Las credenciales son obligatorias";
        } else {
            //comprobamos que contiene el id_empleado y el pin correctamente
            $datos = explode("-", $credencial, 2);

            if (count($datos) != 2) {
                $errores['credencial'] = "Formato incorrecto. Use CODIGO-PIN";
            } else {
                $codigo = trim($datos[0]);
                $pin = trim($datos[1]);
            }
        }

        if (!empty($errores)) {
            //si no es válido volvemos a la vista de login con los datos rellenados
            self::view('login_view', ['credencial' => $credencial, 'errores' => $errores]);
            return;
        }
        //echo password_hash($pin, PASSWORD_DEFAULT);
        //llamamos al modelo para validar al usuario
        $lm = new LoginModel();
        $empleado = $lm->buscarEmpleadoPorCodigo($codigo);
        if ($empleado && password_verify($pin, $empleado['pin'])) {
            SessionManager::set('id_empleado', $empleado['id_empleado']);
            SessionManager::set('nombre', $empleado['nombre']);
            SessionManager::set('apellidos', $empleado['apellidos']);
            SessionManager::set('rol', $empleado['rol']);
            header('Location: ' . BASE_URL);
            exit();
        }
        //si no es válido volvemos a la vista de login con error
        $errores['general'] = "Usuario y password incorrectos";

        self::view('login_view', ['credencial' => $credencial, 'errores' => $errores]);
        return;
    }
    public static function logout()
    {
        //destruimos la sesion
        SessionManager::destruirSesion();
        SessionManager::set('mensaje_flash', 'Sesión cerrada correctamente.');
        //redirigimos a login con mensaje por URL
        header("Location: " . BASE_URL . "login");
        exit();
    }
}
