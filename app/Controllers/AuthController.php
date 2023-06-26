<?php

namespace app\Controllers;

use app\Models\User;
use Exception;

class AuthController{

    public function login($e){
        try{
            $user = new User();
            $user = $user->where('user', @$e->user)->first();
            if(!$user)
                throw new Exception('Usuario incorrecto');
            
            if( !password_verify($e->password, $user->password) )
                throw new Exception( 'Usuario incorrecto.');
            
            // auth()->setAuth($user);
            
            return redirect('home');
        }catch(Exception $e){
            return view('index', array('message' => $e->getMessage()));
        }
    }

    // public function logout(){
    //     auth()->removeAuth();
    //     return redirect('/');
    // }
}