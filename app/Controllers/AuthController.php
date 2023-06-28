<?php

namespace app\Controllers;

use app\Middleware\AuthMiddleware;
use app\Models\User;
use Exception;

class AuthController{

    /**
     * @param object $request
     * @return string
     */
    public function login($request): string
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
            
            redirect('/home');
        }catch(Exception $exception){
            return view('index', array('message' => $exception->getMessage()));
        }
    }

    /**
     * @param object $request
     */
    public function passwordChange($request): string
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
            
            redirect('/home');
        } catch(Exception $exception) {
            return view('users.password-change', array('message' => $exception->getMessage()));
        }
    }
    
    /**
     * @param int $id
     * @return string
     */
    public function passwordReset(int $id): string
    {
        if( !AuthMiddleware::AuthCheck() )
            AuthMiddleware::removeAuth();
        try {
            $userModel = new User();
            $user = $userModel->find( $id );
            $user->password = password_hash( '123456', PASSWORD_BCRYPT );
            $userModel->update($user);
            
            setMessage('La contraseña se reestableció correctamente.', 'message-success');
            
            redirect('/home');
        } catch(Exception $exception) {
            return view('users.show', array('message' => $exception->getMessage()));
        }
    }

    /**
     * @param object $request
     * @return string
     */
    public function register(object $request): string
    {
        try {

            if( empty($request->name) )
                throw new Exception('Nombre requerido.');
            
            if( empty($request->username) )
                throw new Exception('Nombre de usuario requerido.');
            
            if( empty($request->password) )
                throw new Exception('Password requerido.');

            $userModel = new User();
            $request->password = password_hash( $request->password , PASSWORD_BCRYPT );
            $userModel->create($request);
            
            setMessage('Su registro se realizó con éxito. Ahora puede iniciar sesion', 'message-success');
            
            redirect('/');
            
        } catch (Exception $exception) {
            setMessage('Ocurrió un error al intentar registrarse. Por favor, intente nuevamente.', 'message-error');
            return view('register');
        }
    }

    /**
     * @return void
     */
    public function logout(): void
    {
        AuthMiddleware::removeAuth();
        redirect('/');
    }
}