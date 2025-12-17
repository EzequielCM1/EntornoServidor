<?php

class Router {
    private static array $router = [];

    public static function get(string $uri, $callback){
        self::$router['GET'][$uri] =$callback;
    }
    public static function set(string $uri, $callback){
        self::$router['POST'][$uri] =$callback;
    }
    public static function getAll(){
        return self::$router;
    }
    public static function handleRoute(string $method, string $url){
        // comprobar en mi array si existe un metodo y esa url
        // if(isset(self::$router[$method][$url])){
        //     call_user_func(self::$router[$method][$url]);
        // }else{
        //     echo "La ruta no existe ";
        // }
        $method = $_SERVER['REQUEST_METHOD'] ?? "GET";
        $url  = $_SERVER['REQUEST_URI'] ?? "/";
        
    }
}
$router::get("/", function(){echo "Bienbenido a la pagina principal";});
$router::get("/login", function(){echo "bienbenido a la pagina login";});
$router::post("/login", function(){echo "Te has metido por post en el login - valoracion";});

echo "<pre>";
echo $router::getAll();
echo "</pre>";

Router::handleRoute("POST","/login");

?>