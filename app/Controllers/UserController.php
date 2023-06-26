<?php

namespace app\Controllers;

// use app\Middleware\AuthMiddleware;
use app\Models\User;
use Exception;

class UserController{

    public function index(){
        // AuthMiddleware::AuthCheck();
        $users = new User();
        $users = $users->all();
        // $userAuth = auth()->getAuth();
        
        return view('users.index', ['users' => $users ]);
    }
    public function create(){
        return view('users.create');        
    }
    public function store($e){
        try{
            if( empty($e->name) )
                throw new Exception('Nombre requerido');
            if( empty($e->username) )
                throw new Exception('Nombre de usuario requerido');
                
            $user = new User();
            $e->password = password_hash('123456', PASSWORD_BCRYPT);
            $user->create($e);

            return redirect('home');
        }catch(Exception $e){
            return view('users.create', ['message' => 'Ocurrió un error al guardar el usuario.']);
        }
    }
    public function show($u){
        $user = new User();
        $u = $user->find($u->id);
        return view('users.show');        
    }
    public function edit(){
        $users = new User();
        
    }
    public function udpate(){
        $users = new User();
        
    }
    public function destroy(){
        $users = new User();
        
    }
}