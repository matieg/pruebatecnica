<?php
use app\Controllers\Controller;
use app\Middleware\AuthMiddleware;

/**
 * Obtiene la ruta base del archivo
 * @param string $filename Nombre del archivo
 * @return string Retorna la ruta absoluta del archivo
 */
function basePath(string $filename): string
{
    return dirname(__FILE__, 2).'/'.$filename;
}

 /**
 * Obtiene el nombre del proyecto desde el public/index
 */
function projectName(): string
{
    $projectname = str_replace( 'public/index.php', '', $_SERVER['SCRIPT_NAME'] );
    $projectname = str_replace( '/' , '' , $projectname );
    return $projectname;
}

 /**
 * Verifica si existe la funcion view y devuelve la vista generada por el controlador
 * 
 * @param string $route Ruta de la vista a renderizar separadas por puntos. Ej: users.index
 * @param array $data Los datos o variables que se le pueden pasar a la vista, son opcionales.
 * @return string Retorna loq ue se va a mostrar en la vista
 */
if (! function_exists('view')) {
    function view(string $route, array $data = []): string
    {
        $controller = new Controller();
        return $controller->view($route, $data);
    }
}

 /**
 * Verifica si ya esta creada la funcion redirect y redirecciona a una vista ya creada en algun controlador
 * @param string $route Url de la vista a la que se va a redireccionar
 */
if (! function_exists('redirect')) {
    
    function redirect(string $route): void
    {
        $controller = new Controller();
        $controller->redirect($route);
    }
}

 /**
 * Obtiene los datos del usuario autenticado
 */
if (! function_exists('auth')) {
    function auth()
    {
        return AuthMiddleware::getAuth();
    }
}

 /**
 * Guarda el mensaje en la variable session
 * @param string $message Mensaje que se va a mostrar
 * @param string $type tipo de mensaje, la clase css que se va a usar pueden ser (message-error message-success message-info)
 */
function setMessage(string $message, ?string $type = ''): void
{
    $_SESSION['message'] = [];
    $_SESSION['message']['type'] = $type;
    $_SESSION['message']['text'] = $message;
}

 /**
 * Retorna el mensaje guardado
 * @return object|null Retorna $message->type $message->text sino existe $message retorna null
 */
function getMessage(): object|null
{
    if( !isset($_SESSION['message']) || !$_SESSION['message'] )
        return null;

    $message = $_SESSION['message'];
    $_SESSION['message'] = [];

    return (object)$message;
}
