<?php
namespace Ezequiel\App\controllers;

class Controller {

    protected static function view(string $vista, array $datos = []){

        extract($datos);

        require_once "../app/views/$vista.php";
    }
}
