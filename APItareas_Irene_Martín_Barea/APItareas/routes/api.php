<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TareaController;
use App\Http\Controllers\EtiquetaController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

//Definir las solicitudes post para el registro y el login de usuarios
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

// Rutas protegidas que requieren autenticación mediante Sanctum
Route::middleware('auth:sanctum')->group(function(){
    //Cierre de sesión con get
    Route::get('logout', [AuthController::class, 'logout']);
    //Recursos de tareas y etiquetas
    Route::resource('/tareas', TareaController::class);
    Route::resource('/etiquetas', EtiquetaController::class);
});
