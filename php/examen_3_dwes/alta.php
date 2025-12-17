<?php

session_start();
// cargar la configuracion flobal de rutas app root
require_once 'includes/config.php';

// cargar el modelo usando la constante de rta absoluta
require_once APP_ROOT . '/models/IncidenciaModel.php';


if (!isset($_SESSION['usuario'])) {
    header("location: login.php");
    exit();
}
// Mensaje
$mensaje = null;
$tipo_mensaje = "";

if (isset($_SESSION['mensaje'])) {
    $mensaje = $_SESSION['mensaje']['mensaje'];
    $tipo_mensaje = $_SESSION['mensaje']['tipo'];
    unset($_SESSION['mensaje']);
}

// variables
$errores = [];
$asunto = "";
$tipo = "";
$horas = 0;

// formulario
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $asunto = htmlspecialchars(trim($_POST['asunto'] ?? ''));
    $tipo = htmlspecialchars(trim($_POST['tipo_incidencia'] ?? ''));
    $horas = htmlspecialchars(trim($_POST['horas_estimadas'] ?? 0));

    if ($asunto == "") {
        $errores["asunto"] = "El asunto no puede estar vacio";
    }
    if ($tipo == "") {
        $errores["tipo"] = "La tipo no puede estar vacio";
    }
    if ($horas == 0) {
        $errores["horas"] = "Debes ponerle un horas ";
    }
    if ($horas <= 0) {
        $errores["horas"] = "Debe ser un entero";
    }

    if (empty($errores)) {

        // insertamos la nueva incidencia
        // logica del controlador
        $incidenciasModel = new IncidenciaModel();
        $filas = $incidenciasModel->crearIncidencia($asunto, $tipo, $horas);

        // si se ha afectado lineas muestre mensaje de exito si no muestre el de error
        if ($filas) {
            $mensaje = "Incidencia creada correctamente";
            $tipo_mensaje = "exito";

            $_SESSION['mensaje'] = [
                "mensaje" => $mensaje,
                "tipo" => $tipo_mensaje
            ];

            header("Location: index.php");
            exit();
        } else {
            $mensaje = "Error al crear incidencia";
            $tipo_mensaje = "error";

            $_SESSION['mensaje'] = [
                "mensaje" => $mensaje,
                "tipo" => $tipo_mensaje
            ];

            header("Location: alta.php");
            exit();
        }
    }
}



// incluimos el html
require_once APP_ROOT . '/views/alta_view.php';
