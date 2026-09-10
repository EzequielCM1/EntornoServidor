<?php
/**
 * P.Lluyot-2025
 */
// Definimos la RUTA RAÍZ del proyecto.
define('APP_ROOT', dirname(__DIR__));

// if ($_SERVER['HTTP_HOST'] == 'localhost') {
//     define('BASE_URL', '/php/varios/EX_2526/EX_2526_MVC/EX_DWES_MVC_2526_huerto/public/');
// } else {
//     define('BASE_URL', '/');
// }

// Automatización de BASE_URL (ruta web)
// 1. Obtenemos la ruta del script que se está ejecutando (siempre será public/index.php)
$scriptName = $_SERVER['SCRIPT_NAME']; // Ej: /mi_proyecto/public/index.php

// 2. Obtenemos el directorio de ese script
$scriptDir = dirname($scriptName);     // Ej: /mi_proyecto/public

// 3. Normalizamos las barras (para compatibilidad con Windows/Linux) y aseguramos el slash final
$baseUrl = str_replace('\\', '/', $scriptDir); // Cambiar \ por / (fix windows)
$baseUrl = rtrim($baseUrl, '/') . '/';         // Asegurar que termine en /

// Definimos la constante
define('BASE_URL', $baseUrl);
