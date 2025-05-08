<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::view('/login', 'auth.login')->name('login');
Route::view('/register', 'auth.register')->name('register');

Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::get('/dashboard', function () {
    // Verificar si el token existe en la sesión
    if (!session()->has('token')) {
        return redirect()->route('login');  // Redirigir a login si no hay token
    }

    // Recuperar el token
    $token = session()->get('token');

    // Aquí podrías agregar lógica para validar el token si es necesario

    return view('dashboard');
})->middleware('auth:sanctum')->name('dashboard');

Route::get('/logout', function () {
    Http::withToken(Session::get('token'))->post(env('APP_URL') . '/api/logout');
    Session::flush();
    return redirect('/login');
})->name('logout');