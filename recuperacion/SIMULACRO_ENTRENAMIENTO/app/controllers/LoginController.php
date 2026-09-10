<?php

namespace Ezequiel\App\controllers;

use Ezequiel\App\models\LoginModel;
use Ezequiel\Lib\SessionManager;

class LoginController extends Controller
{

    public static function index()
    {
        //implementar la función index
        //llamar a LoginModel cuando sea necesario
        //Emplear la clase SesionManager cuando sea necesario
        //llamar a la vista login_view cuando sea necesario
        SessionManager::usuarioAutenticado('usuario', '');
        $mensajeFlash = SessionManager::getMensajeFlash();
        $usuario = SessionManager::get('usuario_antiguo') ?? '';
        $error   = SessionManager::get('login_errores') ?? [];

        // limpiamos los errores tras la lectura
        SessionManager::eliminar('login_errores');

        self::view('login_view', [
            'mensajeFlash' => $mensajeFlash,
            'usuario'      => $usuario,
            'error'        => $error
        ]);
    }
    public static function verificarUsuario()
    {
        //implementar la función verificar usuario
        //llamar a LoginModel cuando sea necesario
        //Emplear la clase SesionManager cuando sea necesario

        $usuario  = $_POST['usuario'] ?? '';
        $password = $_POST['password'] ?? '';

        if (empty($usuario)) {
            $error['usuario'] = 'Usuario es requerido';
            SessionManager::set('login_errores', $error);
            SessionManager::set('usuario_antiguo', $usuario);
            header("Location: " . BASE_URL . "login");
            exit();
        }
        if (empty($password)) {
            $error['password'] = 'Contraseña es requerida';
            SessionManager::set('login_errores', $error);
            SessionManager::set('usuario_antiguo', $usuario);
            header("Location: " . BASE_URL . "login");
            exit();
        }

        $model = new LoginModel();
        $user  = $model->getUsuario($usuario);

        if ($user && password_verify($password, $user['password_hash'])) {
            $datosUsuario = [
                "usuario"=> $usuario,
                "id_usuario"=> $user['id']
            ];
            SessionManager::set('usuario', $datosUsuario);
            
            // limpiamos el usuario guardado
            SessionManager::eliminar('usuario_antiguo');
            
            header("Location: " . BASE_URL);
            exit();
        } else {
            SessionManager::setMensajeFlash('Credenciales incorrectas. Inténtelo de nuevo.', '✖', 'error');
            SessionManager::set('usuario_antiguo', $usuario);
            header("Location: " . BASE_URL . "login");
            exit();
        }
    }
    public static function logout()
    {
        //implementar la función de logout
        //llamar a LoginModel cuando sea necesario
        //Emplear la clase SesionManager cuando sea necesario
        SessionManager::destruirSesion();
        SessionManager::setMensajeFlash('Sesión cerrada correctamente.', '✔', 'ok');
        header("Location: " . BASE_URL . "login");
        exit();
    }
}
