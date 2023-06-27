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
                throw new Exception('Nombre de usuario requerido.');
            if( empty($request->password) )
                throw new Exception('Password requerido.');

            $user = new User();
            $user = $user->where('username', @$request->username)->first();
            if(!$user)
                throw new Exception('Usuario incorrecto');
            
            if( !password_verify($request->password, $user->password) )
                throw new Exception( 'Contraseña incorrecta.');

            if( password_verify('123456', $user->password) ){
                setMessage('Se le aconseja cambiar la contraseña que se le asigno por defecto. <br/> Puede cambiarla haciendo <a href="password-change">click aqui </a>.', 'message-warning');
            }
            
            AuthMiddleware::setAuth($user);
            
            return redirect('/home');
        }catch(Exception $error){
            return view('index', array('message' => $error->getMessage()));
        }
    }

    public function passwordChange($request)
    {
        if( !AuthMiddleware::AuthCheck() )
            AuthMiddleware::removeAuth();

        try {
            if( empty($request->password) )
                throw new Exception('Contraseña requerida.');

            if( empty($request->newpassword) )
                throw new Exception('Contraseña nueva requerida.');

            if( empty($request->repeatpassword) )
                throw new Exception('Debe repetir su nueva password.');

                
            $userModel = new User();
            $user = $userModel->find( auth()->id );
            
            if( password_verify($request->newpassword, $user->password) )
                throw new Exception('La contraseña no puede ser igual a la anterior.');
            
            $user->password = password_hash( $request->newpassword, PASSWORD_BCRYPT );
            $userModel->update($user);
            
            setMessage('Su contraseña se modificó con éxito.', 'message-success');
            
            return redirect('/home');
        } catch(Exception $error) {
            return view('users.password-change', array('message' => $error->getMessage()));
        }
    }
    
    public function passwordReset($request)
    {
        if( !AuthMiddleware::AuthCheck() )
            AuthMiddleware::removeAuth();
        try {
            $userModel = new User();
            $user = $userModel->find( $request->id );
            $user->password = password_hash( '123456', PASSWORD_BCRYPT );
            $userModel->update($user);
            
            setMessage('La contraseña se reestableció correctamente.', 'message-success');
            
            return redirect('/home');
        } catch(Exception $error) {
            return view('users.show', array('message' => $error->getMessage()));
        }
    }

    public function logout()
    {
        AuthMiddleware::removeAuth();
        return redirect('/');
    }
}