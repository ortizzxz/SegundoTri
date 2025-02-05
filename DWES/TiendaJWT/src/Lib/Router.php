<?php
namespace Lib;
use Controllers\ErrorController;
// para almacenar las rutas que configuremos desde el archivo index.php
class Router
{

    private static $routes = [];
    //para ir añadiendo los métodos y las rutas en el tercer parámetro.
    public static function add(string $method, string $action, callable $controller): void
    {
        //die($action);
        $action = trim($action, '/');

        self::$routes[$method][$action] = $controller;

    }

    // Este método se encarga de obtener el sufijo de la URL que permitirá seleccionar
    // la ruta y mostrar el resultado de ejecutar la función pasada al metodo add para esa ruta
    // usando call_user_func()
    public static function dispatch(): void
{
    $method = $_SERVER['REQUEST_METHOD'];
    $uri = preg_replace('#Instituto/DWES/TiendaJWT/#', '', $_SERVER['REQUEST_URI']);
    $uri = trim($uri, '/');

    $matched = false;

    foreach (self::$routes[$method] as $route => $callback) {
        $pattern = preg_replace('/:([^\/]+)/', '(?<$1>[^/]+)', $route);
        $pattern = "#^{$pattern}$#";

        if (preg_match($pattern, $uri, $matches)) {
            $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
            echo call_user_func_array($callback, $params);
            $matched = true;
            break;
        }
    }

    if (!$matched) {
        ErrorController::error404();
    }
}

    
}


