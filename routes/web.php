<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PetController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::view('/login', 'auth.login')->name('login');
Route::view('/register', 'auth.register')->name('register');

Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::get('/logout', function () {
    Http::withToken(Session::get('token'))->post(env('APP_URL') . '/api/logout');
    Session::flush();
    return redirect('/login');
})->name('logout');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


//Rutas solo accesibles para clientes
Route::middleware(['auth', 'role:Cliente'])->group(function () {

    // Dashboard cliente
    Route::get('/dashboard/client', [UserController::class, 'showPets'])->name('client.dashboard');

    // Crear Mascota
    Route::get('/pets/create', function () {
        return view('client.createPet');
    })->name('pets.create');

    Route::middleware(['auth', 'verified'])->group(function () {
        Route::post('/pets', [PetController::class, 'store'])->name('pets.store');
        Route::get('/pets/{pet}', [PetController::class, 'show'])->name('client.showPet');
        Route::get('/pets/{pet}/edit', [PetController::class, 'edit'])->name('pets.editPet');
        Route::put('/pets/{pet}', [PetController::class, 'update'])->name('pets.updatePet');
    });

    // Perfil del cliente
   Route::middleware(['verified'])->group(function () {
        Route::get('/showClient', [UserController::class, 'show'])->name('client.showClient');
        Route::get('/editClient', [UserController::class, 'edit'])->name('client.editClient');
        Route::put('/showClient', [UserController::class, 'update'])->name('client.updateClient');
    });

    
});

//Rutas solo accesibles para Admin y Veterinarios
Route::middleware(['auth'])->group(function () {

    // Dashboard Admin/Vet
    Route::get('/dashboard/veterinary', function () {
        return view('veterinary.dashboard');
    })->middleware('role:Admin,Veterinario')->name('veterinary.dashboard');
    
    // Perfil del cliente
   Route::middleware(['auth', 'role:Admin,Veterinario'])->group(function () {
        Route::get('/showProfile', [UserController::class, 'show'])->name('veterinary.showProfile');
        Route::get('/editProfile', [UserController::class, 'edit'])->name('veterinary.editProfile');
        Route::put('/showProfile', [UserController::class, 'update'])->name('veterinary.updateProfile');
    });
});



