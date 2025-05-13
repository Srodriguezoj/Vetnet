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
     * Show the form for creating a new resource.
     */
    public function create($appointmentId)
    {
        $appointment = Appointment::with('pet', 'pet.owner')->findOrFail($appointmentId);
        return view('veterinary.createMedicalRecord', compact('appointment'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $validated = $request->validate([
            'id_pet' => 'required|exists:pets,id',
            'id_veterinary' => 'required|exists:veterinaries,id',
            'id_appointment' => 'required|exists:appointments,id',
            'diagnosis' => 'required|string',
            'id_prescription' => 'nullable|exists:prescriptions,id',
            'id_invoice' => 'nullable|exists:invoices,id',
            'id_vaccine' => 'nullable|exists:vaccines,id',
        ]);

        // Crear el historial médico
        $medicalRecord = new MedicalRecord($validated);
        $medicalRecord->save();

        $appointment = Appointment::find($request->id_appointment);
        $appointment->state = 'Completada';
        $appointment->save();

        //Se guarda la vacuna de la mascota
        if ($request->filled('id_vaccine')) {
        PetVaccination::create([
            'id_pet' => $validated['id_pet'],
            'id_vaccine' => $validated['id_vaccine'],
            'id_medical_record' => $medicalRecord->id,
            'date_administered' => Carbon::now()->toDateString(),
        ]);
    }

        // Redirigir al dashboard o donde sea necesario
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

    public function show(MedicalRecord $medicalRecord)
    {
        return view('client.showMedicalRecord', compact('medicalRecord'));
    }
}
