<?php
/**
 * P.Lluyot-2025
 */

namespace Pepelluyot\App\controllers;

use Pepelluyot\App\models\LogisticaModel;
use Pepelluyot\Lib\SessionManager;
use SessionManager as GlobalSessionManager;

class LogisticaController extends Controller
{
    /**
     * Verifica que el usuario esté autenticado
     */
    private static function verificarAutenticacion()
    {
        if (SessionManager::estaAutenticado('id_empleado') == false) {
            header('Location: ' . BASE_URL . 'login');
            exit();
        };
    }
    public static function index()
    {
        //si el usuario NO está autentificado redirigimos a home
        self::verificarAutenticacion();

        //si hay mensaje flash lo mostramos y eliminamos
        $mensaje = SessionManager::get('mensaje_flash') ?? null;
        //lo eliminamos de la sesión para que no aparezca más
        SessionManager::eliminar('mensaje_flash');
        //recuperamos de la sesión los datos del empleado
        $empleado = [
            'id_empleado' => SessionManager::get('id_empleado'),
            'nombre' => SessionManager::get('nombre'),
            'apellidos' => SessionManager::get('apellidos'),
            'rol' => SessionManager::get('rol')
        ];
        //llamamos al modelo
        $modelo = new LogisticaModel();
        $vehiculos = $modelo->getVehiculos();
        $data = [
            'vehiculos' => $vehiculos,
            'empleado' => $empleado,
            'mensaje' => $mensaje
        ];

        self::view("index_view", $data);
    }
    public static function asignarVehiculo()
    {
        //si el usuario NO está autentificado redirigimos a home
        self::verificarAutenticacion();
        $id = trim($_POST['id_vehiculo']) ?? '';
        if ($id == '' || !ctype_digit($id)) {
            SessionManager::set('mensaje_flash', 'Por favor selecciona un vehículo');
            header('Location: ' . BASE_URL);
            exit;
        }
        //almacenamos en sesion el vehículo clickado
        SessionManager::set('id_vehiculo', $id);
        //redirigimos a /carga
        header("Location: " . BASE_URL . "carga");
        exit();
    }
    public static function mostrarCarga()
    {
        //si el usuario NO está autentificado redirigimos a home
        self::verificarAutenticacion();

        //si el camion no está en sesión reenviamos a la página de vehiculos con un mensaje flash
        $id_vehiculo = SessionManager::get('id_vehiculo') ?? null;
        if (!$id_vehiculo) {
            SessionManager::set("mensaje_flash", "Seleccione uno de los vehículos disponibles");
            header("Location: " . BASE_URL);
            exit();
        }
        //si hay mensaje flash lo mostramos y eliminamos
        $mensaje = SessionManager::get('mensaje_flash') ?? null;
        //lo eliminamos de la sesión para que no aparezca más
        SessionManager::eliminar('mensaje_flash');
        //recuperamos de la sesión los datos del empleado
        $empleado = [
            'id_empleado' => SessionManager::get('id_empleado'),
            'nombre' => SessionManager::get('nombre'),
            'apellidos' => SessionManager::get('apellidos'),
            'rol' => SessionManager::get('rol')
        ];
        //recuperamos los datos del vehículo
        $modelo = new LogisticaModel();
        $vehiculo = $modelo->getVehiculo($id_vehiculo);
        if (empty($vehiculo)) {
            SessionManager::set("mensaje_flash", "Se ha producido un error en el vehículo seleccionado, por favor eliga uno de nuevo");
            header("Location: " . BASE_URL);
            exit();
        }

        //obtenemos un listado de paquetes pendientes por prioridad y peso:
        $paquetes = $modelo->getPaquetes();
        if (count($paquetes) == 0) {
            $mensaje = "No hay paquetes disponibles";
        }
        //pasamos los datos a la vista
        $data = [
            'vehiculo' => $vehiculo,
            'mensaje' => $mensaje,
            'empleado' => $empleado,
            'paquetes' => $paquetes
        ];
        self::view("carga_view", $data);
    }
    public static function calcularCargaOptima()
    {
        //si el usuario NO está autentificado redirigimos a home
        self::verificarAutenticacion();
        //si el camion no está en sesión reenviamos a la página de vehiculos con un mensaje flash
        $id_vehiculo = SessionManager::get('id_vehiculo') ?? null;
        if (!$id_vehiculo) {
            SessionManager::set("mensaje_flash", "Seleccione uno de los vehículos disponibles");
            header("Location: " . BASE_URL);
            exit();
        }
        //si hay mensaje flash lo mostramos y eliminamos
        $mensaje = SessionManager::get('mensaje_flash') ?? null;
        //lo eliminamos de la sesión para que no aparezca más
        SessionManager::eliminar('mensaje_flash');

        //recuperamos de la sesión los datos del empleado
        $empleado = [
            'id_empleado' => SessionManager::get('id_empleado'),
            'nombre' => SessionManager::get('nombre'),
            'apellidos' => SessionManager::get('apellidos'),
            'rol' => SessionManager::get('rol')
        ];
        //recuperamos los datos del vehículo
        $modelo = new LogisticaModel();
        $vehiculo = $modelo->getVehiculo($id_vehiculo);
        if (empty($vehiculo)) {
            SessionManager::set("mensaje_flash", "Se ha producido un error en el vehículo seleccionado, por favor eliga uno de nuevo");
            header("Location: " . BASE_URL);
            exit();
        }

        //obtenemos un listado de paquetes pendientes ordenados por prioridad y peso:
        $paquetes = $modelo->getPaquetes();

        //marcamos los paquetes que caben en el vehiculo.
        $carga_maxima = $vehiculo['carga_maxima'];
        $volumen_maximo = $vehiculo['volumen_maximo'];
        //reiniciamos
        $peso = $volumen = 0;
        $btn_confirmar = 'disabled'; //disabled cuando no hay papquetes seleccionados, lo inicializamos.
        $cod_paquetes = []; //inicializamos un array de paquetes seleccionados.
        foreach ($paquetes as &$paquete) {
            if ($peso + $paquete['peso'] <= $carga_maxima && $volumen + $paquete['volumen'] <= $volumen_maximo) {
                $paquete['modo'] = "Aceptado";
                $peso += $paquete['peso'];
                $volumen += $paquete['volumen'];
                //almacenamos un array en la sesión con los paquetes seleccionados:
                $cod_paquetes[] = $paquete['codigo'];
            } else {
                $paquete['modo'] = "Rechazado";
            }
        }
        //si se ha cargado algún paquete procedemos a habilitar el botón "Confirmar Envío"
        if (!empty($cod_paquetes)) {
            $volumen = round($volumen, 2);
            $peso = round($peso, 2);
            //almacenamos en sesión el array y el volumen y peso total
            SessionManager::set('cod_paquetes', $cod_paquetes);
            // SessionManager::set('volumen_actual', $volumen);
            // SessionManager::set('peso_actual', $peso);

            $btn_confirmar = '';
        } else {
            $mensaje = "Al vehículo seleccionado no se le puede asignar ninguno de los paquetes disponibles. Eliga otro vehículo.";
        }

        $data = [
            'vehiculo' => $vehiculo,
            'mensaje' => $mensaje,
            'empleado' => $empleado,
            'paquetes' => $paquetes,
            'btn_confirmar' => $btn_confirmar,
            'volumen_actual' => $volumen,
            'peso_actual' => $peso
        ];
        self::view("carga_view", $data);
    }

    public static function confirmarEnvio()
    {
        //obtenemos los codigos de los paquetes y los datos del camion a través de la sesión
        //si el usuario NO está autentificado redirigimos a home
        self::verificarAutenticacion();

        //si el camion no está en sesión reenviamos a la página de vehiculos con un mensaje flash
        $id_vehiculo = SessionManager::get('id_vehiculo') ?? null;
        $cod_paquetes = SessionManager::get('cod_paquetes') ?? null;
        if (!$id_vehiculo || !$cod_paquetes) {
            SessionManager::set("mensaje_flash", "Error al realizar la carga de paquetes.");
            header("Location: " . BASE_URL . "carga");
            exit();
        }

        //actualiamos los estado
        //vehiculo -> "En Ruta"
        //paquetes --> "En Transito"
        $modelo = new LogisticaModel();
        //recupero la matricula del vehiculo
        $vehiculo = $modelo->getVehiculo($id_vehiculo);
        $matricula = $vehiculo['matricula'] ?? 'Desconocido';

        $num = $modelo->actualizarCarga($id_vehiculo, $cod_paquetes);
        if (!$num) {
            SessionManager::set("mensaje_flash", "Error al realizar la carga de paquetes.");
            header("Location: " . BASE_URL . "carga");
            exit();
        } else {
            //liberamos de la sesión la carga
            SessionManager::eliminar('cod_paquetes');
            SessionManager::eliminar('id_vehiculo');
            SessionManager::set("mensaje_flash", "Vehículo $matricula cargado con éxito. Buen viaje");
            header("Location: " . BASE_URL);
            exit();
        }
    }
}
