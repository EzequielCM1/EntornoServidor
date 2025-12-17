<?php
use Ezequiel\App\Coche;
use Ezequiel\Lib\Utilidades;
use Ezequiel\Lib\MenuHTML;

// require_once "/src/App/coche.php";
// require_once "/src/Lib/utilidades.php";

spl_autoload_register(function ($clase) {
    //Definimos el prefijo que queremos quitar (tu "Vendor")
    $prefijo = 'Ezequiel\\';
    //Quitamos el prefijo de la clase (Pepelluyot\App\Coche -> App\Coche)
    // Usamos str_replace para borrar "Pepelluyot\" del principio
    $clase_relativa = str_replace($prefijo, '', $clase);
    //Cambiamos las barras invertidas por barras de directorio (App\Coche -> App/Coche)
    $ruta = "./src/".str_replace('\\', '/', $clase_relativa) . '.php';
    if (file_exists($ruta)) require_once $ruta;
    else die("Error: No se pudo cargar la clase $clase en la ruta $ruta");
});


// $coche = new Coche("lamborguini", "aventador");
// $util = new Utilidades();
// $util->saludar();
// echo "\n";
$enlaces = [
    "google" => "https://www.google.com",
    "tiempo" => "https://www.eltiempo.es/"
];
$menu = new MenuHTML($enlaces);

$menu->agregarOpcion("hola", "https://www.google.com");
echo $menu->mostrarHorizontal();


// echo "Entramos en el index \n";
// echo "metodo". $_SERVER['REQUEST_METHOD']."</br>\n";
// echo "uri". $_SERVER['REQUEST_URI']."</br>";
?>
