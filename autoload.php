<?php
/**
 * Autoload
 * @param string $class Ruta de la clase que se va a cargar
 */
spl_autoload_register(function(string $class)
{
    $class = lcfirst($class);
    $route = '../'.str_replace('\\', '/', $class).'.php';
    
    if( file_exists($route) )
        require_once $route;
    else{
        die('No se econtro la clase');
    }
});