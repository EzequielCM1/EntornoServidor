<?php

define ('APP_ROOT', dirname(__DIR__));

if($_SERVER['HTTP_HOST'] == 'localhost'){
    define('BASE_URL', '/proyectos/php/recuperacion/FantasyBoss/public/');
}else {
    define('BASE_URL', '/');
}