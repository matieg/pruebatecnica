<?php
namespace Helpers;

use app\Controllers\Controller;

class Route extends Controller{
    private static $routes = [];
    private static $paramsmatches;

    
    public static function get($uri, $callback)
    {
        $uri = trim($uri, '/');
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
    public static function middleware($uri, $callback)
    {
        $middleware = new $uri[0];
        $a = $middleware->{$uri[1]}();
        if($a)
            return $callback();
        else
            return false;
            // return redirect('');
        
    }

    public static function dispatch()
    {
        
        $projectname = projectName();
        
        $uri = $_SERVER['REQUEST_URI'];
        
        $uri = trim($uri, '/');
        
        $method = $_SERVER['REQUEST_METHOD'];
        
        $postParams = $_POST ?? null;

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
            
            $fullRoute = $projectname.'/'.$route['uri'];
            $fullRoute = trim($fullRoute, '/');
            
            if( preg_match("#^$fullRoute$#", $uri, $matches) ){
                self::$paramsmatches = $matches;
                return $route;
            }
            return null;
        });

        if(!$routeMatch){
            return redirect('error');
        }

        $routeMatch = array_values($routeMatch)[0];
        
        $callback = $routeMatch['callback'];
        
        $paramsReplacedNames = null;
        if( strpos($routeMatch['uri'], ':') !== false )
        {
            $paramsReplacedNames = self::replaceRouteParams($routeMatch['uri']);
            $paramsReplacedNames = array_combine($paramsReplacedNames[1], array_slice(self::$paramsmatches, 1));
        }        

        if( is_callable($callback) && !is_array($callback) ){
            $response = $callback( (object) $paramsReplacedNames, (object) $postParams );
        }
        
        if( is_array($callback) ){
            if($paramsReplacedNames == null)
                $paramsReplacedNames = $postParams;
                
            $controller = new $callback[0];
            $response = $controller->{ $callback[1] }( (object) $paramsReplacedNames, $postParams );
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