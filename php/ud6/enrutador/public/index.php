<?php

// require_once "./lib/Router";


spl_autoload_register(function ($clase) {
    //Definimos el prefijo que queremos quitar (tu "Vendor")
    $prefijo = 'enrutador\\';
    //Quitamos el prefijo de la clase (Pepelluyot\App\Coche -> App\Coche)
    // Usamos str_replace para borrar "Pepelluyot\" del principio
    $clase_relativa = str_replace($prefijo, '', $clase);
    //Cambiamos las barras invertidas por barras de directorio (App\Coche -> App/Coche)
    $ruta = "../".str_replace('\\', '/', $clase_relativa) . '.php';
    if (file_exists($ruta)) require_once $ruta;
    else die("Error: No se pudo cargar la clase $clase en la ruta $ruta");
});
use enrutador\Lib\Router;
// echo "Entramos en el index \n";
// echo "metodo". $_SERVER['REQUEST_METHOD']."</br>\n";
// echo "uri". $_SERVER['REQUEST_URI']."</br>";

// Router::get();
echo Router::get("/", function(){
    echo "Hola desde la raiz";
});

Router::handleRoute();

