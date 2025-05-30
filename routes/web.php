<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PetController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VeterinaryController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\VaccineController;
use App\Http\Controllers\MessagesController;

Route::get('/', function () {
    return view('auth.login');
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
    Route::get('/showClient', [UserController::class, 'show'])->name('client.showClient');
    Route::get('/editClient', [UserController::class, 'edit'])->name('client.editClient');
    Route::put('/showClient', [UserController::class, 'update'])->name('client.updateClient');
    Route::put('client/cambiar-contraseña', [UserController::class, 'updatePassword'])->name('client.updatePassword');
   
    //Crear citas
    Route::get('appointments/create', [AppointmentController::class, 'showForm'])->name('appointments.create');
    Route::post('appointments/store', [AppointmentController::class, 'store'])->name('appointments.store');
    Route::post('/appointments/checkAvailability', [AppointmentController::class, 'checkAvailability'])->name('appointments.checkAvailability');
    Route::delete('/appointments/{appointment}', [AppointmentController::class, 'destroy'])->name('appointments.destroy');

    //Historial clinico
    Route::get('/pets/{pet}/medicalRecords', [PetController::class, 'showMedicalRecords'])->name('client.showMedicalRecords');
    Route::get('/medical-records/{medicalRecord}', [MedicalRecordController::class, 'show'])->name('medicalRecords.show');

    //Descara de documentos
    Route::get('/prescription/{id}/download', [PrescriptionController::class, 'download'])->name('prescription.download');
    Route::get('/invoice/{invoice}/download', [InvoiceController::class, 'download'])->name('invoice.download');

    //Ruta para contacto
    Route::get('/client/contact', [MessagesController::class, 'contactForm'])->name('client.contact');
    Route::post('/client/contact', [MessagesController::class, 'sendMessage'])->name('client.contact.send');
});

//Rutas solo accesibles para Admin y Veterinarios
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard/veterinary', function () {
        return view('veterinary.dashboard');
    })->middleware('role:Admin,Veterinario')->name('veterinary.dashboard');
    
    // Perfil vet-admin
   Route::middleware(['auth', 'role:Admin,Veterinario'])->group(function () {
        Route::get('/showProfile', [UserController::class, 'show'])->name('veterinary.showProfile');
        Route::get('/editProfile', [UserController::class, 'edit'])->name('veterinary.editProfile');
        Route::put('/showProfile', [UserController::class, 'update'])->name('veterinary.updateProfile');
        Route::put('perfil/cambiar-contraseña', [UserController::class, 'updatePassword'])->name('veterinary.updatePassword');

        //Gestionar citas
        Route::get('/veterinary/showDates', [VeterinaryController::class, 'showDates'])->name('veterinary.showDates');
        Route::put('/appointments/{appointment}/state/{state}', [AppointmentController::class, 'updateState'])->name('appointments.updateState');

        //Gestionar registros de citas
        Route::resource('medical-records', MedicalRecordController::class);
        Route::get('/medicalRecords/create/{appointment}', [MedicalRecordController::class, 'create'])->name('medical-records.create');
        Route::post('/prescriptions', [PrescriptionController::class, 'store'])->name('prescriptions.store');
        Route::post('/medical-records', [MedicalRecordController::class, 'store'])->name('medicalRecords.store');
        Route::post('/invoices', [InvoiceController::class, 'store'])->name('invoices.store');
        Route::resource('invoices', InvoiceController::class)->except(['store']);
        Route::post('/vaccine', [VaccineController::class, 'store'])->name('vaccine.store'); 

        //Mostrar mascotas
        Route::get('/veterinary/pets', [VeterinaryController::class, 'showAllPets'])->name('veterinary.showPets');
        Route::get('/veterinary/pet/{pet}', [VeterinaryController::class, 'showPet'])->name('veterinary.showPet');
        Route::get('/veterinary/pet/{pet}/medicalRecords', [VeterinaryController::class, 'showPetMedicalRecords'])->name('veterinary.showPetMedicalRecords');
        Route::get('/veterinary/pet/{pet}/prescriptions', [VeterinaryController::class, 'showPetPrescriptions'])->name('veterinary.petPrescriptions');
        Route::get('/pet/{pet}/medical-record/{medicalRecord}', [MedicalRecordController::class, 'showMedicalRecord'])->name('veterinary.medicalRecords.show');
    });

    //Crear veterinarios (Solo para admin)
    Route::middleware(['auth', 'role:Admin'])->group(function () {
        Route::get('/veterinary/create', [VeterinaryController::class, 'create'])->name('veterinary.create');
        Route::post('/veterinary', [VeterinaryController::class, 'store'])->name('veterinary.store');
        Route::get('/veterinary', [VeterinaryController::class, 'index'])->name('veterinary.showVeterinaries');
        Route::delete('/veterinary/{id}', [VeterinaryController::class, 'delete'])->name('veterinary.delete');

        //Mostrar facturas
       Route::get('/invoices', [VeterinaryController::class, 'showInvoices'])->name('veterinary.showInvoices');
       Route::post('/invoice/{invoice}/changeState', [InvoiceController::class, 'changeState'])->name('invoice.changeState');
       Route::get('/veterinary/dates', [VeterinaryController::class, 'showAllDates'])->name('veterinary.showAllDates');

       //Mensajes de contacto
       Route::get('/admin/messages', [MessagesController::class, 'showMessages'])->name('veterinary.showMessages');
       Route::get('/admin/messages/{message}', [MessagesController::class, 'showMessage'])->name('veterinary.showMessage');
    });

});



