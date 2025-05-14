<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PetController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\VeterinaryController;
use App\Http\Controllers\Api\AppointmentController;
use App\Http\Controllers\Api\PrescriptionController;
use App\Http\Controllers\Api\MedicalRecordController;
use App\Http\Controllers\Api\InvoiceController;
use App\Http\Controllers\Api\VaccineController;
use App\Http\Controllers\Api\MessagesController;

//Endspoints de la API para aplicaciones externas
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

//Rutas protegidas por Sanctum (usuarios logueados)
Route::middleware(['auth:sanctum'])->group(function(){

    Route::get('/logout', [AuthController::class, 'logout']);
    Route::get('/user', function (Request $request) { return $request->user();
    });

    //Rutas para role='Cliente'
    Route::middleware('role:Cliente')->group(function () {

        // Dashboard cliente: lista de mascotas
        Route::get('/client/pets', [UserController::class, 'showPets']);

        // Mascotas (cliente)
        Route::post('/client/pets', [PetController::class, 'store']);
        Route::get('/client/pets/{pet}', [PetController::class, 'show']);
        Route::put('/client/pets/{pet}', [PetController::class, 'update']);

        // Perfil cliente
        Route::get('/client/profile', [UserController::class, 'show']);
        Route::put('/client/profile', [UserController::class, 'update']);
        Route::put('/client/password', [UserController::class, 'updatePassword']);

        // Citas
        Route::post('/appointments', [AppointmentController::class, 'store']);
        Route::post('/appointments/check', [AppointmentController::class, 'checkAvailability']);
        Route::delete('/appointments/{appointment}', [AppointmentController::class, 'destroy']);

        // Historial médico
        Route::get('/client/pets/{pet}/medical-records', [PetController::class, 'showMedicalRecords']);
        Route::get('/medical-records/{id}', [MedicalRecordController::class, 'show']);

        // Descarga de documentos
        Route::get('/prescriptions/{id}/download', [PrescriptionController::class, 'download']);
        Route::get('/invoices/{id}/download', [InvoiceController::class, 'download']);

        // Contacto
        Route::post('/client/messages', [MessagesController::class, 'sendMessage']);
    });

    //Rutas para role='Admin' y role='Veterinario'
    Route::middleware('role:Veterinario,Admin')->group(function () {

        // Perfil
        Route::get('/veterinary/profile', [UserController::class, 'show']);
        Route::put('/veterinary/profile', [UserController::class, 'update']);
        Route::put('/veterinary/password', [UserController::class, 'updatePassword']);

        // Citas
        Route::get('/veterinary/appointments', [VeterinaryController::class, 'showDates']);
        Route::put('/appointments/{appointment}/state/{state}', [AppointmentController::class, 'updateState']);

        // Registros médicos
        Route::get('/medical-records/{appointment}/create', [MedicalRecordController::class, 'create']);
        Route::post('/medical-records', [MedicalRecordController::class, 'store']);
        Route::post('/prescriptions', [PrescriptionController::class, 'store']);
        Route::post('/invoices', [InvoiceController::class, 'store']);
        Route::post('/vaccines', [VaccineController::class, 'store']);

        // Mascotas
        Route::get('/veterinary/pets', [VeterinaryController::class, 'showAllPets']);
        Route::get('/veterinary/pets/{pet}', [VeterinaryController::class, 'showPet']);
        Route::get('/veterinary/pets/{pet}/medical-records', [VeterinaryController::class, 'showPetMedicalRecords']);
        Route::get('/veterinary/pets/{pet}/prescriptions', [VeterinaryController::class, 'showPetPrescriptions']);
        Route::get('/medical-records/{pet}/{medicalRecord}', [MedicalRecordController::class, 'showMedicalRecord']);
    });

    //Rutas para role='Admin'
    Route::middleware('role:Admin')->group(function () {

        // Gestión de veterinarios
        Route::post('/veterinarians', [VeterinaryController::class, 'store']);
        Route::get('/veterinarians', [VeterinaryController::class, 'index']);
        Route::delete('/veterinarians/{id}', [VeterinaryController::class, 'delete']);

        // Facturas
        Route::get('/invoices', [VeterinaryController::class, 'showInvoices']);
        Route::post('/invoice/{invoice}/changeState', [InvoiceController::class, 'changeState']);

        // Todas las citas
        Route::get('/veterinary/dates', [VeterinaryController::class, 'showAllDates']);

        // Mensajes de contacto
        Route::get('/admin/messages', [MessagesController::class, 'showMessages']);
        Route::get('/admin/messages/{message}', [MessagesController::class, 'showMessage']);
    });

});


