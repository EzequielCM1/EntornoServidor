<?php

namespace Ezequiel\App\controllers;

use Ezequiel\App\controllers\Controller;
use Ezequiel\App\models\LogisticaModel;
use Ezequiel\Lib\SessionManager;

class LogisticaController extends Controller
{

    public static function index()
    {
        
        if (!SessionManager::comprobarSession("usuario")) {
            header("Location: " . BASE_URL . "login");
            exit();
        }

        $mensaje = null;
        $tipo_mensaje = "";

        if (isset($_SESSION['mensaje'])) {
            $mensaje = $_SESSION['mensaje']['mensaje'];
            $tipo_mensaje = $_SESSION['mensaje']['tipo'];
            unset($_SESSION['mensaje']);
        }
      
        $logisticamodel = new LogisticaModel();
        $datos = $logisticamodel->obtenerTodos();


        $empleado = $_SESSION['usuario'] ?? null;
        self::view("index_view", ["mensaje"=>$mensaje, "tipo_mensaje"=>$tipo_mensaje, "datos"=>$datos, "empleado"=>$empleado]);
    }
    private static function verificarAutenticacion()
    {
        if (!SessionManager::estaAutenticado("usuario")) {
            header("Location: " . BASE_URL . "login");
            exit();
        }
    }
     public static function asignarVehiculo(){
        self::verificarAutenticacion();

        $id = $_POST['id_vehiculo'] ?? '';

        if (empty($id)) {
            SessionManager::mensajeTipo("Por favor selecciona un vehículo", "flash-error");
            header("Location: " . BASE_URL);
            exit();
        }

        SessionManager::set('id_vehiculo', $id);
        header("Location: " . BASE_URL . "carga");
        exit();
        

     }
    public static function mostrarCarga()
    {
        self::verificarAutenticacion();

        $id_vehiculo = SessionManager::get('id_vehiculo');
        if (!$id_vehiculo) {
            SessionManager::mensajeTipo("Seleccione un vehículo primero", "flash-error");
            header("Location: " . BASE_URL);
            exit();
        }

        $mensaje = null;
        $tipo_mensaje = "";
        if (isset($_SESSION['mensaje'])) {
            $mensaje = $_SESSION['mensaje']['mensaje'];
            $tipo_mensaje = $_SESSION['mensaje']['tipo'];
            unset($_SESSION['mensaje']);
        }

        $modelo = new LogisticaModel();
        $vehiculo = $modelo->getVehiculo($id_vehiculo);
        $paquetes = $modelo->getPaquetes();

        $empleado = $_SESSION['usuario'] ?? null;

        self::view("carga_view", [
            "vehiculo" => $vehiculo,
            "paquetes" => $paquetes,
            "empleado" => $empleado,
            "mensaje" => $mensaje,
            "tipo_mensaje" => $tipo_mensaje
        ]);
    }
    public static function calcularCargaOptima(){
        self::verificarAutenticacion();
        $id_vehiculo = SessionManager::get('id_vehiculo');
        if (!$id_vehiculo) {
            SessionManager::mensajeTipo("Seleccione un vehículo primero", "flash-error");
            header("Location: " . BASE_URL);
            exit();
        }
        $modelo = new LogisticaModel();
        $vehiculo = $modelo->getVehiculo($id_vehiculo);
        $paquetes = $modelo->getPaquetes();

        $carga_maxima = $vehiculo['carga_maxima'];
        $volumen_maximo = $vehiculo['volumen_maximo'];

        $peso_acumulado = 0;
        $volumen_acumulado = 0;
        $paquetes_seleccionados = [];

        

    }
}
