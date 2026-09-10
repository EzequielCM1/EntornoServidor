<?php

namespace Ezequiel\App\controllers;

use Ezequiel\Lib\SessionManager;

class Controller {

    protected static function mostrarVista(string $vista, array $datos = []) {
        SessionManager::iniciarSesion();
        $datos['BASE_URL'] = defined('BASE_URL') ? BASE_URL : '/';
        extract($datos);
        require_once "../app/views/$vista.php";
    }
}
