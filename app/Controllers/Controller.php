<?php
namespace app\Controllers;

class Controller
{

    /**
     * Renderiza la vista
     * @param string $route Ruta de la vista a renderizar separadas por puntos. Ej: users.index
     * @param array $data Los datos o variables que se le pueden pasar a la vista, son opcionales.
     * @return string $content Retorna loq ue se va a mostrar en la vista
     */
    public function view(string $route, array $data = [])
    {
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

    /**
     * Redirecciona a una vista ya creada en algun controlador
     * @param string $route Url de la vista a la que se va a redireccionar
     */
    public function redirect($route): void
    {
        $projectName = projectName() ? '/'.projectName() : '';
        header("Location: {$projectName}{$route}");
        exit();
    }
}