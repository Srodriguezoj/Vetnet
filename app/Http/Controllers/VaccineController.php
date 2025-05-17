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
use App\Models\Vaccine;
use App\Models\PetVaccination;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Validator;
use Illuminate\Support\Facades\Auth;
use \stdClass;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class VaccineController extends Controller
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
     * Funcion para guardar una nueva vacuna
     */
    public function store(Request $request)
    {
        $request->validate([
            'vaccine_type' => 'required|string',
            'stamp' => 'required|string',
            'batch_num' => 'required|string',
            'expedition_number' => 'required|string',
        ]);

       $vacine = Vaccine::create($request->all());

        return response()->json(['id' => $vacine->id,'vaccine_type' => $vacine->vaccine_type,'stamp' => $vacine->stamp,'batch_num' => $vacine->batch_num,
            'expedition_number' => $vacine->expedition_number,
        ]);
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
}
