<?php
namespace Helpers;

use app\Controllers\Controller;

class Route extends Controller{
    private static $routes = [];
    private static $paramsmatches;

    
    public static function get($uri, $callback)
    {
        $uri = trim($uri, '/');
        // self::$routes['GET'][$uri] = $callback;
        $data = [
            'method' => 'GET',
            'uri' => $uri,
            'callback' => $callback
        ];
        array_push(self::$routes, $data);
    }
    
    public static function post($uri, $callback)
    {
        $uri = trim($uri, '/');
        $data = [
            'method' => 'POST',
            'uri' => $uri,
            'callback' => $callback
        ];
        array_push(self::$routes, $data);
    }

    public static function dispatch()
    {
        
        $projectname = projectName();
        
        $uri = $_SERVER['REQUEST_URI'];
        
        $uri = trim($uri, '/');
        
        $method = $_SERVER['REQUEST_METHOD'];
        
        $params = $_POST ?? null;

        $routesMethod = array_filter(self::$routes, function($route) use ($method){
            if($route['method'] == $method)
                return $route;
            return null;
        });
        $routeMatch = array_filter($routesMethod, function($route) use ($uri, $projectname){
            
            if( strpos($route['uri'], ':') !== false ){
                $routeParamsReplaced = self::replaceRouteParams($route['uri']);
                $route['uri'] = $routeParamsReplaced[0];
            }
            
            $k = $projectname.'/'.$route['uri'];
            $k = trim($k, '/');
            
            if( preg_match("#^$k$#", $uri, $matches) ){
                self::$paramsmatches = $matches;
                return $route;
            }
            return null;
        });
        if(!$routeMatch){
            echo 404;
            return redirect('error');
        }

        $routeMatch = array_values($routeMatch)[0];
        
        $callback = $routeMatch['callback'];
        
        if( strpos($routeMatch['uri'], ':') !== false )
        {
            $params = self::replaceRouteParams($routeMatch['uri']);
            $params = array_combine($params[1], array_slice(self::$paramsmatches, 1));
        }        
        
        if( is_callable($callback) ){
            $response = $callback( (object) $params );
        }

        if( is_array($callback) ){
            $controller = new $callback[0];
            $response = $controller->{ $callback[1] }( (object) $params );
        }
        
        if( is_array($response) || is_object($response) ){
            echo json_encode($response);
        }else{
            echo $response;
        }
    }
    private static function replaceRouteParams($route)
    {
        $paramNames = [];
        $segments = explode('/', $route);
        
        foreach ($segments as $key => $segment) {
            if (strpos($segment, ':') === 0) {
                $paramName = str_replace(':', '', $segment);
                $segments[$key] = '([a-zA-Z0-9]+)';
                $paramNames[] = $paramName;
            }
        }
        $route = implode('/', $segments);        
        return [$route, $paramNames];
    }
}