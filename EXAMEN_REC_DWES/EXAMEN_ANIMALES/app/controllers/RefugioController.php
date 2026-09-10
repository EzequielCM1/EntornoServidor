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

}
