<?php
namespace Helpers;

use App\Controllers\Controller;

class Route extends Controller{
    private static $routes = [];
    private static $paramsMatches;
    
    /**
     * Rutas que se ejecutaran con el metodo get
     * @param string $uri Url de la ruta
     * @param callable $callback funcion asociada a la ruta (controlador que usa)
     */
    public static function get(string $uri, array|callable $callback): void
    {
        $uri = trim($uri, '/');
        $data = [
            'method' => 'GET',
            'uri' => $uri,
            'callback' => $callback
        ];
        array_push(self::$routes, $data);
    }

    /**
     * Rutas que se ejecutaran con el metodo post
     * @param string $uri Url de la ruta
     * @param callable $callback funcion asociada a la ruta (controlador que usa)
     */
    public static function post(string $uri, array|callable $callback): void
    {
        $uri = trim($uri, '/');
        $data = [
            'method' => 'POST',
            'uri' => $uri,
            'callback' => $callback
        ];
        array_push(self::$routes, $data);
    }

    /**
     * Encuentra la ruta para ejecutar el callback correspondiente
     */
    public static function dispatch()
    {        
        $projectName = projectName();
        
        $uri = $_SERVER['REQUEST_URI'];
        
        $uri = trim($uri, '/');
        
        $method = $_SERVER['REQUEST_METHOD'];
        
        $postParams = $_POST ?? null;

        $routesMethod = array_filter(self::$routes, function($route) use ($method){
            if($route['method'] == $method)
                return $route;
            return null;
        });
        $routeMatch = array_filter($routesMethod, function($route) use ($uri, $projectName){
            
            $route['uri'] = self::replaceRouteParams($route['uri'])['route'] ?? $route['uri'];
            
            $fullRoute = $projectName.'/'.$route['uri'];
            $fullRoute = trim($fullRoute, '/');
            
            if( preg_match("#^$fullRoute$#", $uri, $matches) ){
                self::$paramsMatches = $matches;
                return $route;
            }
            return null;
        });
        if(!$routeMatch){
            return redirect('/error');
        }

        $routeMatch = array_values($routeMatch)[0];
        
        $callback = $routeMatch['callback'];
        
        $paramsReplacedNames = self::replaceRouteParams($routeMatch['uri']);

        if($paramsReplacedNames)
            $paramsReplacedNames = array_combine($paramsReplacedNames['paramNames'], array_slice(self::$paramsMatches, 1));
        else
            $paramsReplacedNames = $postParams;
        
        if( is_callable($callback) && !is_array($callback) ){
            $response = $callback( (object) $paramsReplacedNames, (object) $postParams );
        }
        
        if( is_array($callback) ){                
            $controller = new $callback[0];
            $response = $controller->{ $callback[1] }( (object) $paramsReplacedNames, $postParams );
        }

        if( is_array($response) || is_object($response) ){
            echo json_encode($response);
        }else{
            echo $response;
        }
    }

    /**
    * retorna la ruta con los parametros (:id) remplazados por expresiones regulares y sus nombres
    * @param string $route ruta original
    * @return array Retorna la ruta actualizada con expresiones regulares y los nombres de los parametros.
    *               Si no se encuentran devuelve null
    */
    private static function replaceRouteParams(string $route): ?array
    {
        $paramNames = [];
        $segments = explode('/', $route);
        
        if (strpos($route, ':') !== false) {
            foreach ($segments as $key => $segment) {
                if (strpos($segment, ':') === 0) {
                    $paramName = str_replace(':', '', $segment);
                    $segments[$key] = '([a-zA-Z0-9]+)';
                    $paramNames[] = $paramName;
                }
            }
            $route = implode('/', $segments);
            return ['route' => $route, 'paramNames' => $paramNames];
        }
        return null;
    }
}