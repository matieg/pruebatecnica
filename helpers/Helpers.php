<?php
use app\Controllers\Controller;

function basePath($filename)
{
    return dirname(__FILE__, 2).'/'.$filename;
}

function projectName()
{
    $projectname = str_replace( 'public/index.php', '', $_SERVER['SCRIPT_NAME'] );
    $projectname = str_replace( '/' , '' , $projectname );
    return $projectname;
}
/**
 * get the view
 * @param string $route
 * @param array $data
 */
if (! function_exists('view')) {
    function view($route, $data = [])
    {
        $controller = new Controller();
        return $controller->view($route, $data);
        // return Controller::view($route, $data);
    }
}
/**
 * redirect view
 * @param string $route
 */
if (! function_exists('redirect')) {
    function redirect($route)
    {
        $controller = new Controller();
        return $controller->redirect($route);
    }
}

// if (! function_exists('auth')) {
//     function auth()
//     {
//         $session = new SessionHelper();
//         return $session;
//     }
// }