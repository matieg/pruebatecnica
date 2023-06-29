<?php
namespace Helpers;

use App\Controllers\Controller;

class Route extends Controller
{
    private static $routes = [];
    
    /**
     * 
     * @param string $uri Url GET
     * @param array|callable $callback funcion asociada a la ruta (controlador que usa)
     */
    public static function get(string $uri, array|callable $callback): void
    {
        $uri = trim($uri, '/');
        $data = [
            'method' => 'GET',
            'uri' => $uri,
            'callback' => $callback
        ];
        self::$routes[] = $data;
    }

    /**
     * 
     * @param string $uri Url POST
     * @param array|callable $callback funcion asociada a la ruta (controlador que usa)
     */
    public static function post(string $uri, array|callable $callback): void
    {
        $uri = trim($uri, '/');
        $data = [
            'method' => 'POST',
            'uri' => $uri,
            'callback' => $callback
        ];
        self::$routes[] = $data;
    }

    /**
     * Encuentra la ruta para ejecutar el callback correspondiente
     */
    public static function dispatch(): void
    {        
        $uri = $_SERVER['REQUEST_URI'];
        
        $uri = trim($uri, '/');
        
        $method = $_SERVER['REQUEST_METHOD'];
        
        $routesMethod = array_filter(self::$routes, function($route) use ($method){
            if($route['method'] == $method)
                return $route;
            return null;
        });

        $routeMatch = self::findRouteMatch($routesMethod, $uri);

        if(!$routeMatch){
            redirect('/error');
        }

        $callback = $routeMatch['callback'];
        
        if( is_callable($callback) && !is_array($callback) ){
            $response = $callback( ...$routeMatch['paramsCombined'] );
        }
        
        if( is_array($callback) ){
            $controller = new $callback[0];
            if($_POST)
                $response = $controller->{ $callback[1] }( (object) $_POST , ...$routeMatch['paramsCombined'] );
            else 
                $response = $controller->{ $callback[1] }( ...$routeMatch['paramsCombined'] );
        }

        if( is_array($response) || is_object($response) ){
            echo json_encode($response);
        }else{
            echo $response;
        }
    }

    /**
     * @param array $routes 
     * @param string $uri
     * @return array|null Retorna un array de la ruta coincidente con la uri solicitada
     */
    private static function findRouteMatch(array $routes, string $uri): array|null
    {
        foreach( $routes as $route) {

            $routeReplaced = self::relpaceUrl($route['uri']);
            
            $projectName = projectName();
            
            $fullRoute = $projectName.'/'.$routeReplaced;
            $fullRoute = trim($fullRoute, '/');
            
            if( preg_match("#^$fullRoute$#", $uri, $matches) ) {

                $params = self::getParamsCombined($route['uri'], array_slice($matches, 1));
            
                return ['callback' => $route['callback'], 'paramsCombined' => $params];
            }
        }
        return null;
    }

    /**
     * Reemplaza a la ruta los parametros (Ej= :id) por expresiones regulares 
     * @param string $route
     * @return string $route
     */
    public static function relpaceUrl(string $route): string
    {
        if (strpos($route, ':') === 0) 
            return $route;

        $segments = explode('/', $route);

        foreach ($segments as $index => $segment) {
            if (strpos($segment, ':') === 0) {
                $segments[$index] = '([a-zA-Z0-9]+)';             
            }
        }
        $route = implode('/', $segments);
        return $route;
    }

    /**
     * Crea un array tomando como clave lo que viene despues del : en la url que corresponde de $urlParamsValue 
     * @param string $route
     * @param array $urlParamsValues
     * @return array array
     */
    public static function getParamsCombined(string $route, array $urlParamsValues): array
    {
        if (strpos($route, ':') === 0) {
            return [];
        }
        $paramNames = [];
        $segments = explode('/', $route);
        
        foreach ($segments as $segment) {
            if (strpos($segment, ':') === 0) {
                $paramName = str_replace(':', '', $segment);
                $paramNames[] = $paramName;           
            }
        }
        return array_combine($paramNames, $urlParamsValues);
    }
}