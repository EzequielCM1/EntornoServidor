<?php

namespace Ezequiel\App\controllers;

use Ezequiel\App\models\ManagerModel;
use Ezequiel\Lib\SessionManager;

class FantasyLoginController extends Controller {

    // ─────────────────────────────────────────────────────────────────────────
    // GET /login
    // ─────────────────────────────────────────────────────────────────────────
    // TODO:
    // 1. SessionManager::iniciarSesion()
    // 2. Si isset($_SESSION['manager']) → redirect BASE_URL + exit()
    // 3. Inicializar $mensaje = '' y $mensajeError = ''
    // 4. Recoger flash de $_SESSION['mensaje_exito'] y ['mensaje_error'] con unset()
    // 5. mostrarVista('login_view', ['errores'=>[], 'mensaje'=>..., 'mensajeError'=>...])
    // ─────────────────────────────────────────────────────────────────────────
    public static function mostrarFormularioLogin() {
        SessionManager::iniciarSesion();
        if(isset($_SESSION['manager'])){
            header("Location: ".BASE_URL);
            exit();
        }
        $mensaje = "";
        $mensajeError = "";

        if(isset($_SESSION['mensaje_exito'])) {
            $mensaje = $_SESSION['mensaje_exito'];
            unset($_SESSION['mensaje_exito']);
        }
        if(isset($_SESSION['mensaje_error'])) {
            $mensajeError = $_SESSION['mensaje_error'];
            unset($_SESSION['mensaje_error']);
        }
        self::mostrarVista("login_view", ['errores'=>[], 'mensaje'=>$mensaje, 'mensajeError'=>$mensajeError]);
    }


    // ─────────────────────────────────────────────────────────────────────────
    // POST /login
    // ─────────────────────────────────────────────────────────────────────────
    // TODO:
    // 1. SessionManager::iniciarSesion()
    // 2. $credencial = htmlspecialchars(trim($_POST['credencial'] ?? ''))
    // 3. Validar que no esté vacío
    // 4. $partes = explode("-", $credencial) → debe tener 3 partes
    //    Formato: MAN-001-1234
    //    → $partes[0] = "MAN"
    //    → $partes[1] = "001"
    //    → $partes[2] = "1234"
    // 5. Si hay errores → mostrarVista('login_view', [...]) + return
    // 6. $cod_manager = $partes[0] . '-' . $partes[1]  →  "MAN-001"
    //    $pin = $partes[2]
    // 7. new ManagerModel() → autenticarManager($cod_manager, $pin)
    // 8. Si ok → $_SESSION['manager'] = $manager + redirect BASE_URL + exit()
    // 9. Si false → flash 'mensaje_error' + redirect BASE_URL.'login' + exit()
    // ─────────────────────────────────────────────────────────────────────────
    public static function autenticarManager() {
        SessionManager::iniciarSesion();
        if(isset($_SESSION['manager'])) {
            header('Location: '.BASE_URL);
            exit();
        }
        $credencial = htmlspecialchars(trim($_POST['credencial'] ?? ''));
        if(empty($credencial)) {
            SessionManager::crearMensajeFlash('mensaje_error', 'Credencial no puede estar vacía');
            header('Location: '.BASE_URL.'login');
            exit();
        }
        $partes = explode("-", $credencial);
        if(count($partes) !== 3) {
            SessionManager::crearMensajeFlash('mensaje_error', 'Credencial inválida');
            header('Location: '.BASE_URL.'login');
            exit();
        }
        $cod_manager = $partes[0] . '-' . $partes[1];
        $pin = $partes[2];
        $model = new ManagerModel();
        $manager = $model->autenticarManager($cod_manager, $pin);
        if($manager) {
            $_SESSION['manager'] = $manager;
            header('Location: '.BASE_URL);
            exit();
        } else {
            SessionManager::crearMensajeFlash('mensaje_error', 'Credencial inválida');
            header('Location: '.BASE_URL.'login');
            exit();
        }
    }



    // ─────────────────────────────────────────────────────────────────────────
    // GET /logout
    // ─────────────────────────────────────────────────────────────────────────
    // TODO:
    // 1. SessionManager::destruirSesion()
    // 2. SessionManager::iniciarSesion()
    // 3. SessionManager::crearMensajeFlash('mensaje_exito', "Sesión cerrada correctamente")
    // 4. redirect BASE_URL.'login' + exit()
    // ─────────────────────────────────────────────────────────────────────────
    public static function cerrarSesion() {
        SessionManager::iniciarSesion();
        SessionManager::destruirSesion();
        
        // Volvemos a iniciar para el mensaje flash
        SessionManager::iniciarSesion();
        SessionManager::crearMensajeFlash('mensaje_exito', 'Sesión cerrada correctamente');
        
        header('Location: '.BASE_URL.'login');
        exit();
    }
}
