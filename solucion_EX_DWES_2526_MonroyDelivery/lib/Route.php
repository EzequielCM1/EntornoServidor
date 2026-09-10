<?php

/**
 * P.Lluyot-2025
 */

namespace Pepelluyot\Lib;

/**
 * Clase Route para gestionar el enrutamiento de la aplicación.
 * Se encarga de mapear las URLs solicitadas a los controladores o funciones (handlers) correspondientes.
 */
class Route
{
    /**
     * @var array Almacena todas las rutas registradas, organizadas por método HTTP (GET, POST, etc.).
     * La estructura es: self::$routes['GET']['/ruta'] = $handler;
     */
    public static array $routes;

    /**
     * Procesa la solicitud HTTP actual y la dirige al manejador de ruta correspondiente.
     *
     * Este método es el núcleo del enrutador. Realiza los siguientes pasos:
     * 1. Obtiene la URI y el método HTTP de la solicitud.
     * 2. Normaliza la URI para eliminar el directorio base y los parámetros GET, asegurando un formato consistente.
     * 3. Intenta encontrar una coincidencia directa y estática (sin parámetros) para mayor eficiencia.
     * 4. Si no hay coincidencia directa, busca rutas con parámetros (ej. /usuarios/{id}).
     * 5. Extrae los valores de los parámetros de la URI y los pasa al manejador.
     * 6. Si no se encuentra ninguna ruta coincidente, devuelve una respuesta 404 Not Found.
     *
     * @return void
     */
    public static function handleRoute()
    {
        // Recogemos la ruta del script principal (ej. /mi_proyecto/public/index.php)
        $script_name = $_SERVER['SCRIPT_NAME'];
        // Obtenemos la URI completa solicitada por el navegador (ej. /mi_proyecto/public/usuarios/1?param=valor)
        $uri = $_SERVER['REQUEST_URI'];
        // Recogemos el método HTTP de la petición (GET, POST, etc.)
        $method = $_SERVER['REQUEST_METHOD'];


        // 1.- Eliminar la parte del base path de la URI.
        // Esto permite que la aplicación funcione correctamente en subdirectorios.
        $base_ruta = str_replace('index.php', '', $script_name); // ej: /mi_proyecto/public/

        // Limpiamos la ruta para quedarnos sólo con la parte relevante (ej. /usuarios/1?param=valor)
        if ($base_ruta !== '/') {
            $ruta = str_replace($base_ruta, '/', $uri);
        } else {
            $ruta = $uri;
        }

        // 2. Eliminar los parámetros GET (?id=...) para que no afecten al router.
        // `parse_url` nos devuelve solo la parte de la ruta de la URL.
        $ruta = parse_url($ruta, PHP_URL_PATH);

        // 3. Asegurar que la ruta empiece por / y no termine en / (normalización).
        // Esto estandariza el formato para evitar problemas con slashes al final.
        $ruta = '/' . trim($ruta, '/');

        // Primero, hacemos una comprobación directa para rutas estáticas (sin parámetros).
        // Es más rápido que iterar y usar expresiones regulares.
        if (array_key_exists($ruta, self::$routes[$method])) {
            // Si se encuentra, llamamos a su manejador (función o método de controlador).
            call_user_func(self::$routes[$method][$ruta]);
            return; // Terminamos la ejecución del método.
        }

        //divimimos la ruta en partes (separador '/')
        $ruta_parts = explode('/', trim($ruta, '/')); //esta es la que hemos introducido -> array
        //comprobación con parámetros
        foreach (self::$routes[$method] ?? [] as $route => $handler) {
            //comprobamos si la ruta tiene parámetros
            $route_parts = explode('/', trim($route, '/')); //esta es la que iteramos -> array
            //si coinciden en número de partes
            if (count($route_parts) == count($ruta_parts)) {
                $params = [];
                $match = true;
                for ($i = 0; $i < count($route_parts); $i++) {
                    // Comprobar si la parte de la ruta es un parámetro {id}
                    if (preg_match('/^\{(.+)\}$/', $route_parts[$i], $matches)) {
                        $params[] = $ruta_parts[$i];
                    } elseif ($route_parts[$i] != $ruta_parts[$i]) {
                        $match = false;
                        break;
                    }
                }
                if ($match) {
                    call_user_func_array($handler, $params);
                    return;
                }
            }
        }
        // Si después de todas las comprobaciones no se ha encontrado la ruta, enviamos un error 404.
        http_response_code(404);
        echo "<h1>404 - Ruta no encontrada: $ruta</h1>";
    }

    // public static function addRoute(string $method, string $route, callable $handler){
    //     self::$routes[$method][$route]=$handler;
    // }
    /**
     * Registra una nueva ruta para el método HTTP GET.
     *
     * @param string $route La plantilla de la ruta (ej. '/login').
     * @param callable $handler La función o método de controlador que se ejecutará.
     * @return void
     */
    public static function get(string $route, callable $handler)
    {
        self::$routes['GET'][$route] = $handler;
    }

    /**
     * Registra una nueva ruta para el método HTTP POST.
     *
     * @param string $route La plantilla de la ruta (ej. '/login').
     * @param callable $handler La función o método de controlador que se ejecutará.
     * @return void
     */
    public static function post(string $route, callable $handler)
    {
        self::$routes['POST'][$route] = $handler;
    }
}
