<?php

use app\Controllers\AuthController;
use app\Controllers\UserController;
use Helpers\Route;

Route::get('/', function(){
    return view('index');
});

Route::post('/', [AuthController::class, 'login']);

Route::get('/logout', [AuthController::class, 'logout']);

Route::get('/password-change', function(){
    return view('users.password-change');
});

Route::post('/password/change', [AuthController::class, 'passwordChange']);

Route::get('/password/reset/:id', [AuthController::class, 'passwordReset']);
// Route::post('/password/reset/:id', [AuthController::class, 'passwordReset']);

Route::get('/home', [UserController::class, 'index'] );

Route::get('/user/create', [UserController::class, 'create'] );

Route::post('/user/create', [UserController::class, 'store'] );

Route::get('/user/:id', [UserController::class, 'show'] );

Route::post('/user/:id', [UserController::class, 'update'] );

Route::post('/user/delete/:id', [UserController::class, 'destroy'] );

Route::get('/error', function(){
    return view('404');
});

Route::get('/create-db', function(){
    $db_host = DB_HOST;
    $db_user = DB_USER;
    $db_pass = DB_PASS;
    
    $conn = new mysqli($db_host, $db_user, $db_pass);
    
    // Verificar la conexión
    if ($conn->connect_error) {
        die("Error al conectar con la base de datos: " . $conn->connect_error);
    }
    
    $file = "../mysqlseed/database.sql";
    
    $sql = file_get_contents($file);
    
    if (mysqli_multi_query($conn, $sql)) {
        echo "Archivo SQL ejecutado correctamente.";
    } else {
        echo "Error al ejecutar el archivo SQL: " . mysqli_error($conn);
    }
});


// Route::middleware( [AuthMiddleware::class, 'AuthCheck'] , function(){
    
// });

Route::dispatch();