<?php

namespace Ezequiel\App\controllers;

use Ezequiel\App\models\EntrenamientoModel;
use Ezequiel\Lib\SessionManager;

class EntrenamientoController extends Controller
{
    /**
     * Verifica que el usuario esté autenticado
     */
    private static function verificarAutenticacion()
    {
        // TODO 1: Si no hay usuario en sesión, redirigir a BASE_URL . 'login'
        // Puedes usar SessionManager::get(...) o SessionManager::estaAutenticado(...) si existe
    }

    public static function index()
    {
        self::verificarAutenticacion();

        // TODO 2: Comprobar si hay mensaje flash, guardarlo y eliminarlo de la sesión

        // TODO 3: Llamar al EntrenamientoModel para obtener los animales "Sanos"

        $data = [
            // 'animales' => $animales,
            // 'mensaje'  => $mensaje
        ];

        // self::view("entrenamiento/index_view", $data);
    }

    public static function seleccionar()
    {
        self::verificarAutenticacion();

        // TODO 4: Recibir el id del animal por $_POST
        // Si no es válido o está vacío, mensaje flash de error y redirigir a /entrenamiento

        // TODO 5: Si el ID es válido, guardar 'id_animal_seleccionado' en SessionManager

        // Redirigir a /entrenamiento/configurar
        // header("Location: " . BASE_URL . "entrenamiento/configurar");
        // exit();
    }

    public static function mostrarConfiguracion()
    {
        self::verificarAutenticacion();

        // TODO 6: Comprobar que existe 'id_animal_seleccionado' en sesión
        // Si no existe, mensaje de error y redirigir a /entrenamiento

        // TODO 7: Obtener los datos del animal para mostrarlos en la vista
        // Instancia el modelo y busca el animal. Pasa los datos a la vista.

        $data = [];
        // self::view("entrenamiento/config_view", $data);
    }

    public static function confirmar()
    {
        self::verificarAutenticacion();

        // TODO 8: Obtener el 'id_animal_seleccionado' de la sesión
        // Obtener el 'nivel' desde $_POST ('Basico', 'Medio' o 'Avanzado')

        // TODO 9: Instanciar EntrenamientoModel y llamar a registrarEntrenamiento($id_animal, $nivel)
        // El modelo ejecutará la transacción. Si devuelve true, mensaje de éxito.
        // Si devuelve false, mensaje de error.

        // TODO 10: Limpiar la sesión (eliminar 'id_animal_seleccionado')
        
        // Redirigir a /entrenamiento
    }
}
