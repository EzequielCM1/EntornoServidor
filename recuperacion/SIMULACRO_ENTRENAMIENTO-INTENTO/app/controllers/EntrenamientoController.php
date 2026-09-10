<?php

namespace Ezequiel\App\controllers;

use Ezequiel\App\models\EntrenamientoModel;
use Ezequiel\App\models\RefugioModel;
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
        SessionManager::usuarioNoAutenticado("usuario", "login");
    }

    public static function index()
    {
        self::verificarAutenticacion();

        // TODO 2: Comprobar si hay mensaje flash, guardarlo y eliminarlo de la sesión
        $mensajeFlash = SessionManager::getMensajeFlash();

        // TODO 3: Llamar al EntrenamientoModel para obtener los animales "Sanos"
        $model = new EntrenamientoModel;
        $animales = $model->getAnimalesSanos();

        $data = [
             'animales' => $animales,
             'mensajeFlash'  => $mensajeFlash
        ];

        self::view("entrenamiento/index_view", $data);
    }

    public static function seleccionar()
    {
        self::verificarAutenticacion();

        // TODO 4: Recibir el id del animal por $_POST
        // Si no es válido o está vacío, mensaje flash de error y redirigir a /entrenamiento
        $id_animal = $_POST['id_animal'] ?? null ;
        if(empty($id_animal)){
            SessionManager::setMensajeFlash("No hay animal seleccionado","x", "error");
            header("Location: " . BASE_URL . "entrenamiento");
            exit();
        }

        // TODO 5: Si el ID es válido, guardar 'id_animal_seleccionado' en SessionManager
        $model = new RefugioModel;
        $animalvalido = $model->getAnimal($id_animal);
        if($id_animal){
            SessionManager::set("id_animal_seleccionado", $id_animal);
            header("Location: " . BASE_URL . "entrenamiento/configurar");
            exit();
            return;
        } 
        header("Location: " . BASE_URL . "entrenamiento");
        exit();
    
        // Redirigir a /entrenamiento/configurar
        // header("Location: " . BASE_URL . "entrenamiento/configurar");
        // exit();
    }

    public static function mostrarConfiguracion()
    {
        self::verificarAutenticacion();

        // TODO 6: Comprobar que existe 'id_animal_seleccionado' en sesión
        // Si no existe, mensaje de error y redirigir a /entrenamiento
        $id_animal = SessionManager::get("id_animal_seleccionado")?? null;

        if(!$id_animal){
            SessionManager::setMensajeFlash("No hay animal seleccionado","x", "error");
            header("Location: " . BASE_URL . "entrenamiento");
            exit();
        }
        // TODO 7: Obtener los datos del animal para mostrarlos en la vista
        // Instancia el modelo y busca el animal. Pasa los datos a la vista.
        $model = new RefugioModel;
        $animal = $model->getAnimal($id_animal);

        $data = ["animal"=> $animal];
        self::view("entrenamiento/config_view", $data);
    }

    public static function confirmar()
    {
        self::verificarAutenticacion();

        // TODO 8: Obtener el 'id_animal_seleccionado' de la sesión
        $id_animal = SessionManager::get("id_animal_seleccionado")?? null;
        // Obtener el 'nivel' desde $_POST ('Basico', 'Medio' o 'Avanzado')
        $nivel = $_POST['nivel'] ?? null;
        // TODO 9: Instanciar EntrenamientoModel y llamar a registrarEntrenamiento($id_animal, $nivel)
        // El modelo ejecutará la transacción. Si devuelve true, mensaje de éxito.
        // Si devuelve false, mensaje de error.

        $model = new EntrenamientoModel;
        $entrenamiento = $model->registrarEntrenamiento($id_animal, $nivel);
        if($entrenamiento){
            SessionManager::setMensajeFlash("Entrenamiento registrado","guay", "exito");
        }else{
            SessionManager::setMensajeFlash("No se pudo registrar el entrenamiento","x", "error");
        }
        // TODO 10: Limpiar la sesión (eliminar 'id_animal_seleccionado')
        SessionManager::eliminar('id_animal_seleccionado');
        // Redirigir a /entrenamiento
        header("Location: " . BASE_URL . "entrenamiento");
            exit();
    }
}
