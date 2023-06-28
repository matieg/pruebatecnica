<?php
namespace app\Middleware;

use app\Models\User;

class AuthMiddleware{

    /**
     * Verifica si el usuario esta autenticado
     * @return bool retorna verdadero si se encuentra la variable session (auth) del usuario, sino retorna false
     */
    public static function AuthCheck(): bool
    {
        if( isset($_SESSION['auth']) && isset( $_SESSION ) ){
            return true;
        }
        return false;
    }

    /**
     * Obtiene los datos del usuario autenticado
     * @return object|null Retorna los datos del usuario, sino retorna null
     */
    public static function getAuth(): object|null
    {
        if( isset($_SESSION['auth']) && isset( $_SESSION ) )
        {
            return unserialize( $_SESSION['auth'] );
        }
        return null;
    }

    /**
     * Guarda los datos del usuario serializado
     * @param array $data Datos del usuario
     */
    public static function setAuth($data): void
    {   
        $_SESSION['auth'] = serialize($data);
    }

    /**
     * Elimina la session del usuario autenticado y retorna al inicio
     */
    public static function removeAuth(): void
    {   
        unset($_SESSION['auth']);
        session_destroy();
        redirect('/');
    }

}