<?php

namespace Ezequiel\App\controllers;

use Ezequiel\Lib\SessionManager;
use Ezequiel\App\models\RefugioModel;

class RefugioController extends Controller
{
    public static function index()
    {
        //implementar la función index
        //llamar a RefugioModel cuando sea necesario
        //Emplear la clase SesionManager cuando sea necesario
        //llamar a la vista listado_view cuando sea necesario

        SessionManager::usuarioNoAutenticado('usuario', 'login');
        
        $model = new RefugioModel();
        $animales = $model->getAnimales();

        // Extraemos el nombre del usuario de la sesión para pasarlo a la vista
        $usuarioLogueado = SessionManager::get('usuario')['usuario'] ?? 'Invitado';
        
        // Obtenemos posibles mensajes flash
        $mensajeFlash = SessionManager::getMensajeFlash();

        self::view('listado_view', [
            'animales'     => $animales,
            'usuario'      => $usuarioLogueado,
            'mensajeFlash' => $mensajeFlash
        ]);
    }
    /**
     * Muestra la ficha detallada de un animal.
     */
    public static function ficha()
    {
        // PASO 1: Seguridad. 
        // Verificamos que el usuario tiene una sesión activa ('usuario').
        // Si no, lo redirige automáticamente a la página de 'login'.
        SessionManager::usuarioNoAutenticado('usuario', 'login');

        // PASO 2: Captura de datos del formulario.
        // Recuperamos el ID que enviamos en el campo <input type="hidden" name="id" ...>
        $id = $_POST['id'] ?? null;

        if ($id) {
            // PASO 3: Comunicación con el Modelo.
            // Creamos una instancia de RefugioModel para acceder a sus métodos de BD.
            $model = new RefugioModel();
            
            // Llamamos al método que busca un animal por su ID.
            $animal = $model->getAnimalesById($id);

            // Si el animal existe, preparamos la vista.
            if ($animal) {
                // Recuperamos el nombre del usuario de la sesión para mostrarlo en el header.
                $usuarioLogueado = SessionManager::get('usuario')['usuario'] ?? 'Invitado';

                // PASO 4: Carga de la vista detallada.
                // Usamos el método view() heredado de la clase Controller.
                // Pasamos un array con los datos que la vista necesita ($animal y $usuario).
                self::view('ficha_view', [
                    'animal'  => $animal,
                    'usuario' => $usuarioLogueado
                ]);
                return;
            }
        }

        // Si algo falla (no hay ID o el animal no existe), redirigimos al listado principal.
        header("Location: " . BASE_URL);
        exit;
    }
}
