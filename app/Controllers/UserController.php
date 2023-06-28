<?php

namespace app\Controllers;

use App\Middleware\AuthMiddleware;
use App\Models\User;
use Exception;

class UserController
{

    public function index()
    {    
        if( !AuthMiddleware::AuthCheck() )
            AuthMiddleware::removeAuth();

        $userModel = new User();
        $users = $userModel->all();
        
        return view('users.index', ['users' => $users ]);
    }

    public function create()
    {
        if( !AuthMiddleware::AuthCheck() )
            AuthMiddleware::removeAuth();

        return view('users.create');        
    }

    public function store($request)
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

        } catch(Exception $error) {
            return view('users.create', ['message' => 'Ocurrió un error al guardar el usuario.']);
        }
    }

    public function show($id)
    {
        if( !AuthMiddleware::AuthCheck() )
            AuthMiddleware::removeAuth();
            
        $userModel = new User();
        $user = $userModel->find($id);

        return view('users.show', compact('user') );        
    }

    public function edit()
    {
        $users = new User();        
    }

    public function update($request, $id)
    {
        $userModel = new User();

        $request->id = $id;
        $userModel->update($request);

        setMessage('La modificación se realizo con éxito.', 'message-success');

        return redirect('/home');        
    }

    public function destroy($id)
    {
        $userModel = new User();
        $userModel->delete($id);

        setMessage('Usuario eliminado.', 'message-success');

        return redirect('/home');     
    }
}