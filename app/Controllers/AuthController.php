<?php

namespace app\Controllers;

use app\Middleware\AuthMiddleware;
use app\Models\User;
use Exception;

class AuthController{

    public function login(object $request)
    {
        try{
            if( empty($request->username) )
                throw new Exception('Nombre requerido.');
            if( empty($request->password) )
                throw new Exception('Password requerido.');

            $user = new User();
            $user = $user->where('username', @$request->username)->first();
            if(!$user)
                throw new Exception('Usuario incorrecto');
            
            if( !password_verify($request->password, $user->password) )
                throw new Exception( 'Contraseña incorrecta.');
            
            AuthMiddleware::setAuth($user);
            
            return redirect('/home');
        }catch(Exception $error){
            return view('index', array('message' => $error->getMessage()));
        }
    }

    public function logout()
    {
        AuthMiddleware::removeAuth();
        return redirect('/');
    }
}