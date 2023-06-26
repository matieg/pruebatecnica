<?php

namespace app\Controllers;

use app\Middleware\AuthMiddleware;
use app\Models\User;
use Exception;

class AuthController{

    public function login($e){
        try{
            $user = new User();
            $user = $user->where('username', @$e->username)->first();
            if(!$user)
                throw new Exception('Usuario incorrecto');
            
            if( !password_verify($e->password, $user->password) )
                throw new Exception( 'Usuario incorrecto.');
            
            // auth()->setAuth($user);
            AuthMiddleware::setAuth($user);
            
            return redirect('home');
        }catch(Exception $e){
            return view('index', array('message' => $e->getMessage()));
        }
    }

    public function logout(){
        AuthMiddleware::removeAuth();
        return redirect('/');
    }
}