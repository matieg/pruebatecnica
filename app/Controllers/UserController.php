<?php

namespace app\Controllers;

use app\Middleware\AuthMiddleware;
use app\Models\User;
use Exception;

class UserController{

    public function index(){
        if( !AuthMiddleware::AuthCheck() )
            AuthMiddleware::removeAuth();

        $userModel = new User();
        $users = $userModel->all();
        
        return view('users.index', ['users' => $users ]);
    }

    public function create(){
        if( !AuthMiddleware::AuthCheck() )
            AuthMiddleware::removeAuth();

        return view('users.create');        
    }

    public function store($request){
        if( !AuthMiddleware::AuthCheck() )
            AuthMiddleware::removeAuth();

        try{
            if( empty($request->name) )
                throw new Exception('Nombre requerido');
            if( empty($request->username) )
                throw new Exception('Nombre de usuario requerido');
                
            $userModel = new User();
            $request->password = password_hash('123456', PASSWORD_BCRYPT);
            $userModel->create($request);

            return redirect('/home');
        }catch(Exception $error){
            return view('users.create', ['message' => 'Ocurrió un error al guardar el usuario.']);
        }
    }

    public function show($user){
        $userModel = new User();
        $user = $userModel->find($user->id);
        return view('users.show', compact('user') );        
    }

    public function edit(){
        $users = new User();        
    }

    public function update($user, $request){
        $userModel = new User();

        $request['id'] = $user->id;
        $userModel->update($request);

        return redirect('/home');        
    }

    public function destroy($user){
        $userModel = new User();
        $userModel->delete($user->id);
        return redirect('/home');     
    }
}