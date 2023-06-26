<?php
namespace app\Controllers;

class Controller
{
    public function view($route, $data = [])
    {
        //destructura el array y me deja accesder a ellas directamente
        extract($data);
        $route = str_replace('.', '/', $route);
        $routePath = basePath('resources/views/'.$route.'.php');        
        if( file_exists($routePath) )
        {
            ob_start();
            include $routePath;
            $content = ob_get_clean();
            return $content;
        }
        else
        {
            return "Controller not found";
        }
    }

    public function redirect($route)
    {
        $projectName = projectName() ?? '';
        header("Location: /{$projectName}/{$route}");
    }
}