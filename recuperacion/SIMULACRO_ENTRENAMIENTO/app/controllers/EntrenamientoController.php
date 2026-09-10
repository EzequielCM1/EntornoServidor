<?php

namespace Ezequiel\App\controllers;

use Ezequiel\App\models\EntrenamientoModel;
use Ezequiel\Lib\SessionManager;
use Ezequiel\App\models\RefugioModel;

class EntrenamientoController extends Controller
{
    /**
     * Verifica que el usuario esté autenticado
     */
    private static function verificarAutenticacion()
    {
        // Si NO hay usuario en sesión, redirigir a login
        if (!SessionManager::get('usuario')) {
            header("Location: " . BASE_URL . "login");
            exit();
        }
    }

    public static function index()
    {
        self::verificarAutenticacion();

        // TODO 2: Comprobar si hay mensaje flash, guardarlo y eliminarlo de la sesión
        $mensaje = SessionManager::getMensajeFlash();
        // TODO 3: Llamar al EntrenamientoModel para obtener los animales "Sanos"
        // da error ??? 
        $model = new EntrenamientoModel();
        $animales = $model->getAnimalesSanos();
        $data = [
            'animales' => $animales,
            'mensaje'  => $mensaje
        ];

        // self::view("entrenamiento/index_view", $data);
        self::view("entrenamiento/index_view", $data);
    }

    public static function seleccionar()
    {
        self::verificarAutenticacion();

        // TODO 4: Recibir el id del animal por $_POST
        $animal = $_POST['id_animal'];
        // Si no es válido o está vacío, mensaje flash de error y redirigir a /entrenamiento
        if(empty($animal)){
            SessionManager::setMensajeFlash("Animal no encontrado", "error");
            header("Location: " . BASE_URL . "entrenamiento");
            exit();
        }
        
        // TODO 5: Si el ID es válido, guardar 'id_animal_seleccionado' en SessionManager
        $model = new RefugioModel();
        $animal = $model->getAnimalesById($animal);
        if($animal == null){
            SessionManager::setMensajeFlash("Animal no encontrado", "error");
            header("Location: " . BASE_URL . "entrenamiento");
            exit();
        }
        SessionManager::set('id_animal_seleccionado', $animal['id']);
        // Redirigir a /entrenamiento/configurar
        header("Location: " . BASE_URL . "entrenamiento/configurar");
        exit();
    }

    public static function mostrarConfiguracion()
    {
        self::verificarAutenticacion();

        // Comprobar que existe 'id_animal_seleccionado' en sesión
        $id_animal = SessionManager::get('id_animal_seleccionado');
        if (!$id_animal) {
            SessionManager::setMensajeFlash("No has seleccionado ningún animal.", "✖", "error");
            header("Location: " . BASE_URL . "entrenamiento");
            exit();
        }

        // Obtener los datos del animal para mostrarlos en la vista
        $model = new RefugioModel();
        $animal = $model->getAnimalesById($id_animal);

        if (!$animal) {
            SessionManager::setMensajeFlash("El animal seleccionado no existe.", "✖", "error");
            header("Location: " . BASE_URL . "entrenamiento");
            exit();
        }

        $data = [
            'animal' => $animal
        ];
        self::view("entrenamiento/config_view", $data);
    }

    public static function confirmar()
    {
        self::verificarAutenticacion();

        // Obtener el 'id_animal_seleccionado' de la sesión
        $id_animal = SessionManager::get('id_animal_seleccionado');
        // Obtener el 'nivel' desde $_POST ('Basico', 'Medio' o 'Avanzado')
        $nivel = $_POST['nivel'] ?? null;

        if (!$id_animal || !$nivel) {
            SessionManager::setMensajeFlash("Faltan datos para confirmar el entrenamiento.", "✖", "error");
            header("Location: " . BASE_URL . "entrenamiento");
            exit();
        }

        // Instanciar EntrenamientoModel y llamar a registrarEntrenamiento($id_animal, $nivel)
        $model = new EntrenamientoModel();
        $exito = $model->registrarEntrenamiento($id_animal, $nivel);

        if ($exito) {
            SessionManager::setMensajeFlash("Entrenamiento registrado correctamente para el animal.", "✔", "ok");
        } else {
            SessionManager::setMensajeFlash("No se pudo registrar el entrenamiento.", "✖", "error");
        }

        // Limpiar la sesión (eliminar 'id_animal_seleccionado')
        SessionManager::eliminar('id_animal_seleccionado');
        
        header("Location: " . BASE_URL . "entrenamiento");
        exit();
    }
}
