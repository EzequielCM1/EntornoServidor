<?php

define ('APP_ROOT', dirname(__DIR__));

if($_SERVER['HTTP_HOST'] == 'localhost'){
    define('BASE_URL', '/proyectos/php/recuperacion/ExamenMVC4-intento/Examen4_2526/public/');
}else {
    define('BASE_URL', '/');
}