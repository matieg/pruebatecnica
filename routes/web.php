<?php

use app\Controllers\AuthController;
use app\Controllers\UserController;
use Helpers\Route;

Route::get('/', function(){
    return view('index');
});
Route::post('/login', [AuthController::class, 'login']);

Route::get('/home', [UserController::class, 'index'] );

Route::get('/user/create', [UserController::class, 'create'] );
Route::post('/user/create', [UserController::class, 'store'] );

Route::get('/user/:id', [UserController::class, 'show'] );
// Route::put('/user/update/:id', [UserController::class, 'store'] );

Route::get('/error', function(){
    return view('404');
});




Route::get('/create', function(){
    // return 'asdasdasdasd';
    return view('users.index');
});
Route::get('/conparametros/:id/:otro', function($e){
    var_dump($e->id);
    return 'asdasdasd';
});
Route::get('/create-db', function($e){
    $servername = "localhost";
    $username = "root";
    $password = "";
    
    // Establecer conexión con la base de datos
    $conn = new mysqli($servername, $username, $password);
    
    // Verificar la conexión
    if ($conn->connect_error) {
        die("Error al conectar con la base de datos: " . $conn->connect_error);
    }
    
    // Ruta del archivo .sql
    $file = "../mysqlseed/database.sql";
    
    // Leer el contenido del archivo .sql
    $sql = file_get_contents($file);
    
    // Ejecutar el contenido del archivo .sql
    if (mysqli_multi_query($conn, $sql)) {
        echo "Archivo SQL ejecutado correctamente.";
    } else {
        echo "Error al ejecutar el archivo SQL: " . mysqli_error($conn);
    }
});

Route::dispatch();