<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Veterinary;
use App\Models\Pet;
use App\Models\Appointment;
use App\Models\Prescription;
use App\Models\MedicalRecord;
use App\Models\PetVaccination;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Validator;
use Illuminate\Support\Facades\Auth;
use \stdClass;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MedicalRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Funcion para mostrar el formulario para crear un neuvo registro 
     */
    public function create($appointmentId)
    {
        $appointment = Appointment::with('pet', 'pet.owner')->findOrFail($appointmentId);

        return view('veterinary.createMedicalRecord', compact('appointment'));
    }

    /**
     * Crea un nuevo registro en el historial clinico de x mascota
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_pet' => 'required|exists:pets,id',
            'id_veterinary' => 'required|exists:veterinaries,id',
            'id_appointment' => 'required|exists:appointments,id',
            'diagnosis' => 'required|string',
            'id_prescription' => 'nullable|exists:prescriptions,id',
            'id_invoice' => 'nullable|exists:invoices,id',
            'id_vaccine' => 'nullable|exists:vaccines,id',
        ]);
        $medicalRecord = new MedicalRecord($validated);
        $medicalRecord->save();
        $appointment = Appointment::find($request->id_appointment);
        $appointment->state = 'Completada';
        $appointment->save();
        if ($request->filled('id_vaccine')) {
        PetVaccination::create([
            'id_pet' => $validated['id_pet'],
            'id_vaccine' => $validated['id_vaccine'],
            'id_medical_record' => $medicalRecord->id,
            'date_administered' => Carbon::now()->toDateString(),
        ]);
    }
        return redirect()->route('veterinary.showDates')->with('success', 'Historial médico creado correctamente.');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Muestra el historal clinico de una mascota a los clientes
     */
    public function show(MedicalRecord $medicalRecord)
    {
        return view('client.showMedicalRecord', compact('medicalRecord'));
    }

     /**
     * Muestra el historal clinico de una mascota a los veterinarios
     */
   public function showMedicalRecord(Pet $pet, MedicalRecord $medicalRecord)
    {
        return view('veterinary.showMedicalRecord', compact('medicalRecord'));
    }

}
