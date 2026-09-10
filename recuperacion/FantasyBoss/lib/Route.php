<?php

namespace Ezequiel\Lib;


class Route
{

    private static array $routes = [];

    public static function get(string $uri, callable $callback)
    {
        self::$routes['GET'][$uri] = $callback;
    }

    public static function post(string $uri, callable $callback)
    {
        self::$routes['POST'][$uri] = $callback;
    }

    public static function getAll()
    {
        return self::$routes;
    }

    public static function handleRoute()
    {
        //recogemos la ruta
        $script_name = $_SERVER['SCRIPT_NAME'];
        //obtener la URI
        $uri = $_SERVER['REQUEST_URI'];
        //recogemos el método
        $method = $_SERVER['REQUEST_METHOD'];

        //1.- eliminar la parte del base path
        $base_ruta = str_replace('index.php', '', $script_name);

        //limpiamos la ruta y nos quedamos sólo con la parte relevante
        if ($base_ruta !== '/') {
            $ruta = str_replace($base_ruta, '/', $uri);
        } else {
            $ruta = $uri;
        }
        //2.- comprobar en mi array si existe un elemento con ese método y esa uri
        if (isset(self::$routes[$method][$ruta])) {
            call_user_func(self::$routes[$method][$ruta]);
            return;
        } else
            echo "La ruta no existe-> 404 ERROR";

        //3.
        $ruta_parts = explode('/', trim($ruta ,'/')); //Esta es la que hemos introducido -> array
        //Comprobacion con parámtros
        foreach(self::$routes[$method] ?? [] as $route => $handler){
            //Comprobamos si la ruta tiene parámetros
            $route_parts = explode('/', trim($route, '/')); //Sobre esta es la que iteramos -> array

            //////////////////////////////////
            if(count($route_parts)==count($ruta_parts)){
                $params = [];
                $match = true;
                for($i = 0; $i<count($route_parts); $i++){
                    if(preg_match('/^\{(.+)}$/', $route_parts[$i], $matches)){
                        $params[]=$ruta_parts[$i];
                    } elseif($route_parts[$i]!=$ruta_parts[$i]){
                        $match=false;
                        break;
                    }
                }
                if($match){
                    call_user_func_array($handler, $params);
                    return;
                }
            }

        }
        //Si no encuentra la ruta
        http_response_code(404);
        echo "<h1>404 - Ruta no encontrada</h1>";
    }
    

    
}
