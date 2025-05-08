<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

//Rutas protegidas por Sanctum (usuarios logueados)
Route::middleware(['auth:sanctum'])->group(function(){
    Route::get('/logout', [AuthController::class, 'logout']);
});


