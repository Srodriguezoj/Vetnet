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

Route::middleware(['auth'])->get('/dashboard/client', function () {
    if (auth()->user()->role !== 'Cliente') {
        abort(403);
    }
    return view('client.dashboard');
})->name('cliente.dashboard');

Route::middleware(['auth'])->get('/dashboard/admin-vet', function () {
    if (!in_array(auth()->user()->role, ['Admin', 'Veterinario'])) {
        abort(403);
    }
    return view('admin_vet.dashboard');
})->name('admin.dashboard');


Route::get('/logout', function () {
    Http::withToken(Session::get('token'))->post(env('APP_URL') . '/api/logout');
    Session::flush();
    return redirect('/login');
})->name('logout');