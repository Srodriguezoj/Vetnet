<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Veterinary;
use App\Models\Pet;
use App\Models\Appointment;
use App\Models\Prescription;
use App\Models\MedicalRecord;
use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Validator;
use Illuminate\Support\Facades\Auth;
use \stdClass;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;

class PrescriptionController extends Controller
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
    public function create()
    {
        //
    }

    /**
     * Crea una nueva prescripcion
     */
    public function store(Request $request)
    {
        $prescription = Prescription::create($request->all());

        return response()->json(['id' => $prescription->id,'medication' => $prescription->medication,'dosage' => $prescription->dosage,
        'instructions' => $prescription->instructions,'duration' => $prescription->duration,]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
     * Permite descargar una prescripcion en formato PDF
     */
    public function download($id)
    {
        $prescription = Prescription::with('medicalRecord.pet.owner')->findOrFail($id);
        $pet = $prescription->medicalRecord->pet ?? null;
        $owner = $pet->owner ?? null;

        return Pdf::loadView('pdf.prescription', ['prescription' => $prescription,'pet' => $pet,'owner' => $owner,])
        ->download('prescripcion_' . $prescription->id . '.pdf');
    }
}
