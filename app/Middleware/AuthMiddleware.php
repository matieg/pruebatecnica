<?php
namespace app\Middleware;

class AuthMiddleware{

    public static function AuthCheck()
    {
        if( isset($_SESSION['auth']) && isset( $_SESSION ) ){
            // return redirect('./');
            return true;
        }
        // session_destroy();
        return false;
    }
    public static function getAuth()
    {
        if( isset($_SESSION['auth']) && isset( $_SESSION ) )
        {
            return unserialize( $_SESSION['auth'] );
        }
    }
    public static function setAuth($data)
    {   
        $_SESSION['auth'] = serialize($data);
    }
    public static function removeAuth()
    {   
        unset($_SESSION['auth']);
        session_destroy();
    }

}