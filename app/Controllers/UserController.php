<?php

namespace app\Controllers;

use App\Middleware\AuthMiddleware;
use App\Models\User;
use Exception;

class UserController
{

    /**
     * @return string
     */
    public function index(): string
    {    
        if( !AuthMiddleware::AuthCheck() )
            AuthMiddleware::removeAuth();

        $userModel = new User();
        $users = $userModel->all();
        
        return view('users.index', ['users' => $users ]);
    }

    /**
     * @return string
     */
    public function create(): string
    {
        if( !AuthMiddleware::AuthCheck() )
            AuthMiddleware::removeAuth();

        return view('users.create');        
    }

    /**
     * @param object $request
     * @return string
     */
    public function store(object $request): string
    {
        if( !AuthMiddleware::AuthCheck() )
            AuthMiddleware::removeAuth();

        try {
            if( empty($request->name) )
                throw new Exception('Nombre requerido');
            if( empty($request->username) )
                throw new Exception('Nombre de usuario requerido');
                
            $userModel = new User();
            $request->password = password_hash('123456', PASSWORD_BCRYPT);
            $userModel->create($request);

            setMessage('El usuario se creo con éxito. <br/>Su contraseña por defecto es 123456.', 'message-success');
            
            return redirect('/home');

        } catch(Exception $exception) {
            return view('users.create', ['message' => 'Ocurrió un error al guardar el usuario.'.$exception]);
        }
    }

    /**
     * @param int $id
     * @return string
     */
    public function show(int $id): string
    {
        if( !AuthMiddleware::AuthCheck() )
            AuthMiddleware::removeAuth();
            
        $userModel = new User();
        $user = $userModel->find($id);

        return view('users.show', compact('user') );        
    }

    // public function edit()
    // {
    //     $users = new User();        
    // }

    /**
     * @param object $request
     * @param int $id
     * @return string
     */
    public function update(object $request, int $id): string
    {
        try {
            
            $request->id = $id;
            
            if( empty($request->name) )
                throw new Exception('Nombre requerido');

            if( empty($request->username) )
                throw new Exception('Nombre de usuario requerido');

            $userModel = new User();        
            $userModel->update($request);
            
            setMessage('La modificación se realizo con éxito.', 'message-success');
            
            return redirect('/home');

        } catch (Exception $exception) {
            return view('users.show', ['message' => 'Ocurrió un error al modificar el usuario.', 'user' => $request]);
        }
    }

    /**
     * @param int $id
     * @return void
     */
    public function destroy(int $id): void
    {
        $userModel = new User();
        $userModel->delete($id);

        setMessage('Usuario eliminado.', 'message-success');

        redirect('/home');     
    }
}