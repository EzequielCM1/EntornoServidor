<?php

namespace Ezequiel\App\controllers;

use Ezequiel\App\models\FantasyModel;
use Ezequiel\Lib\SessionManager;

class FantasyController extends Controller {

    // ─────────────────────────────────────────────────────────────────────────
    // MÉTODO PRIVADO: verificarSesion()
    // ─────────────────────────────────────────────────────────────────────────
    // TODO:
    // 1. SessionManager::iniciarSesion()
    // 2. Si !isset($_SESSION['manager']) → redirect BASE_URL.'login' + exit()
    // 3. Si !SessionManager::estaAutentificado($_SESSION['manager'])
    //    → redirect BASE_URL.'login' + exit()
    // ─────────────────────────────────────────────────────────────────────────
    private static function verificarSesion() {
        SessionManager::iniciarSesion();
        if(!isset($_SESSION['manager']) || !SessionManager::estaAutentificado($_SESSION['manager'])) {
            header("Location: ".BASE_URL."login");
            exit();
        }
    }


    // ─────────────────────────────────────────────────────────────────────────
    // GET /  →  Mercado de jugadores
    // ─────────────────────────────────────────────────────────────────────────
    // TODO:
    // 1. verificarSesion()
    // 2. $mensaje = '' + recoger flash de $_SESSION['mensaje_flash'] con unset()
    // 3. new FantasyModel() → obtenerJugadores()
    // 4. mostrarVista('jugadores_view', ['jugadores'=>..., 'mensaje'=>...])
    // ─────────────────────────────────────────────────────────────────────────
    public static function index() {
        self::verificarSesion();

        $mensaje = "";
        $mensajeError = "";

        if(isset($_SESSION['mensaje_flash'])) {
            $mensaje = $_SESSION['mensaje_flash'];
            unset($_SESSION['mensaje_flash']);
        }
        if(isset($_SESSION['mensaje_error'])) {
            $mensajeError = $_SESSION['mensaje_error'];
            unset($_SESSION['mensaje_error']);
        }

        // 1. Recoger filtro de la URL
        $posicion = $_GET['posicion'] ?? null;

        $model = new FantasyModel();
        $jugadores = $model->obtenerJugadores($posicion);
        
        self::mostrarVista('jugadores_view', [
            'jugadores' => $jugadores, 
            'mensaje' => $mensaje, 
            'mensajeError' => $mensajeError
        ]);
    }


    // ─────────────────────────────────────────────────────────────────────────
    // GET /jornadas  →  Jornadas abiertas
    // ─────────────────────────────────────────────────────────────────────────
    // TODO:
    // 1. verificarSesion()
    // 2. $mensaje = '' + recoger flash
    // 3. $model->obtenerJornadas() → jornadas con estado 'Abierta'
    // 4. mostrarVista('jornadas_view', ['jornadas'=>..., 'mensaje'=>...])
    // ─────────────────────────────────────────────────────────────────────────
    public static function jornadas() {
        self::verificarSesion();
        $mensaje = '';
        $mensajeError = '';

        if(isset($_SESSION['mensaje_flash'])) {
            $mensaje = $_SESSION['mensaje_flash'];
            unset($_SESSION['mensaje_flash']);
        }
        if(isset($_SESSION['mensaje_error'])) {
            $mensajeError = $_SESSION['mensaje_error'];
            unset($_SESSION['mensaje_error']);
        }

        $model = new FantasyModel();
        $jornadas = $model->obtenerJornadas();
        
        self::mostrarVista('jornadas_view', [
            'jornadas' => $jornadas, 
            'mensaje' => $mensaje, 
            'mensajeError' => $mensajeError
        ]);
    }


    // ─────────────────────────────────────────────────────────────────────────
    // GET /mi-plantilla  →  Plantilla activa del manager en sesión
    // ─────────────────────────────────────────────────────────────────────────
    // TODO:
    // 1. verificarSesion()
    // 2. $mensaje = '' + recoger flash
    // 3. $cod_manager = $_SESSION['manager']['cod_manager']
    // 4. $model->obtenerPlantillaManager($cod_manager)
    // 5. mostrarVista('plantilla_view', ['plantilla'=>..., 'mensaje'=>...])
    // ─────────────────────────────────────────────────────────────────────────
    public static function miPlantilla() {
        self::verificarSesion();
        $mensaje = '';
        $mensajeError = '';

        if(isset($_SESSION['mensaje_flash'])) {
            $mensaje = $_SESSION['mensaje_flash'];
            unset($_SESSION['mensaje_flash']);
        }
        if(isset($_SESSION['mensaje_error'])) {
            $mensajeError = $_SESSION['mensaje_error'];
            unset($_SESSION['mensaje_error']);
        }

        $model = new FantasyModel();
        $plantilla = $model->obtenerPlantillaManager($_SESSION['manager']['cod_manager']);
        
        self::mostrarVista('plantilla_view', [
            'plantilla' => $plantilla, 
            'mensaje' => $mensaje, 
            'mensajeError' => $mensajeError
        ]);
    }


    // ─────────────────────────────────────────────────────────────────────────
    // POST /fichar/{id}  →  Muestra jornadas disponibles para un jugador
    // ─────────────────────────────────────────────────────────────────────────
    // TODO:
    // 1. verificarSesion()
    // 2. $id = intval($id) → si <= 0: flash + redirect BASE_URL + exit()
    // 3. $model->obtenerJugadorPorID($id) → info del jugador
    // 4. Guardar $_SESSION['id_jugador'] = $id
    // 5. $model->obtenerJornadas() → jornadas abiertas con slots > 0
    // 6. mostrarVista('fichar_view', ['jugador'=>..., 'jornadas'=>...])
    // ─────────────────────────────────────────────────────────────────────────
    public static function mostrarFichar($id) {
        self::verificarSesion();
        $model = new FantasyModel();
        $id = intval($id);
        if($id <= 0) {
            SessionManager::crearMensajeFlash('mensaje_error', 'ID de jugador inválido');
            header('Location: '.BASE_URL);
            exit();
        }
        $jugador = $model->obtenerJugadorPorID($id);
        if(empty($jugador)) {
            SessionManager::crearMensajeFlash('mensaje_error', 'Jugador no encontrado');
            header('Location: '.BASE_URL);
            exit();
        }
        $_SESSION['id_jugador'] = $id;
        $jornadas = $model->obtenerJornadas();
        self::mostrarVista('fichar_view', [
            'jugador' => $jugador, 
            'jornadas' => $jornadas
        ]);
    }


    // ─────────────────────────────────────────────────────────────────────────
    // POST /confirmar-fichaje  →  Confirma el fichaje (transacción)
    // ─────────────────────────────────────────────────────────────────────────
    // TODO:
    // 1. verificarSesion()
    // 2. $id_jornada = intval($_POST['id_jornada'] ?? 0)
    // 3. $id_jugador = $_SESSION['id_jugador']
    // 4. $cod_manager = $_SESSION['manager']['cod_manager']
    // 5. $model->confirmarFichaje($cod_manager, $id_jugador, $id_jornada)
    //    → true: flash éxito + redirect BASE_URL.'mi-plantilla' + exit()
    //    → false: flash error + redirect BASE_URL.'jornadas' + exit()
    // ─────────────────────────────────────────────────────────────────────────
    public static function confirmarFichaje() {
        self::verificarSesion();
        $model = new FantasyModel();
        $id_jornada = intval($_POST['id_jornada'] ?? 0);
        $id_jugador = $_SESSION['id_jugador'];
        $cod_manager = $_SESSION['manager']['cod_manager'];
        $resultado = $model->confirmarFichaje($cod_manager, $id_jugador, $id_jornada);
        if($resultado) {
            SessionManager::crearMensajeFlash('mensaje_flash', 'Fichaje confirmado');
            header('Location: '.BASE_URL.'mi-plantilla');
            exit();
        } else {
            SessionManager::crearMensajeFlash('mensaje_error', 'Error al confirmar fichaje');
            header('Location: '.BASE_URL.'jornadas');
            exit();
        }
    }


    // ─────────────────────────────────────────────────────────────────────────
    // POST /liberar/{id}  →  Libera un jugador de la plantilla
    // ─────────────────────────────────────────────────────────────────────────
    // TODO:
    // 1. verificarSesion()
    // 2. $id = intval($id) → si <= 0: flash + redirect BASE_URL.'mi-plantilla'
    // 3. $model->liberarJugador($id)
    //    → true: flash "Jugador liberado correctamente"
    //    → false: flash "Error al liberar el jugador"
    // 4. redirect BASE_URL.'mi-plantilla' + exit()
    // ─────────────────────────────────────────────────────────────────────────
    public static function liberarJugador($id) {
        self::verificarSesion();
        $model = new FantasyModel();
        $id = intval($id);
        if($id <= 0) {
            SessionManager::crearMensajeFlash('mensaje_error', 'ID de jugador inválido');
            header('Location: '.BASE_URL.'mi-plantilla');
            exit();
        }
        $resultado = $model->liberarJugador($id);
        if($resultado) {
            SessionManager::crearMensajeFlash('mensaje_flash', 'Jugador liberado correctamente');
            header('Location: '.BASE_URL.'mi-plantilla');
            exit();
        } else {
            SessionManager::crearMensajeFlash('mensaje_error', 'Error al liberar el jugador');
            header('Location: '.BASE_URL.'mi-plantilla');
            exit();
        }
    }
}
