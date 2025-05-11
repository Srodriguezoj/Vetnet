<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Veterinary;
use App\Models\Pet;
use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Validator;
use Illuminate\Support\Facades\Auth;
use \stdClass;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AppointmentController extends Controller
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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Log de los datos recibidos
        Log::info('Intentando guardar cita con datos:', $request->all());

        // Validar la solicitud
        $request->validate([
                'id_pet' => 'required|exists:pets,id',
                'id_veterinary' => 'required|exists:veterinaries,id',
                'specialty' => 'required|string|in:Interna,Cirugia,Dermatologia,Odontologia,Cardiologia,Preventiva,Etologia',
                'date' => 'required|date',
                'time' => 'required|date_format:H:i',
                'title' => 'required|string|max:200',
                'description' => 'required|string',
            ]);
        
        try {
            
            Appointment::create([
                'id_pet' => $request->id_pet,
                'id_veterinary' => $request->id_veterinary,
                'specialty' => $request->specialty,
                'date_of_birth' => $request->date_of_birth,
                'date' => $request->date,
                'time' => $request->time,
                'title' => $request->title,
                'description' => $request->description,
                'state' => 'Pendiente',
            ]);

            Log::info('Cita creada correctamente');

            return redirect()->route('client.dashboard')->with('success', 'Cita reservada correctamente.');

     
        } catch (Exception $e) {
            Log::error('Error al crear cita: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Hubo un problema al guardar la cita.']);
        }
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

    public function showForm()
    {
        $user = Auth::user();

        $pets = Pet::where('id_owner', Auth::id())->get();
        $specialties = ['Interna', 'Cirugia', 'Dermatologia', 'Odontologia', 'Cardiologia', 'Preventiva', 'Etologia'];

        return view('client.appointments.create', [
            'pets' => $pets,
            'specialties' => $specialties,
        ]);
    }
    
    public function checkAvailability(Request $request)
    {
        $request->validate([
            'specialty' => 'required|string',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
        ]);

        $specialty = $request->specialty;
        $date = $request->date;
        $time = $request->time;

        // Veterinarios ocupados en esa hora
        $veterinarians = Veterinary::whereHas('appointments', function ($query) use ($specialty, $date, $time) {
            $query->where('specialty', $specialty)
                ->where('date', $date)
                ->where('time', $time);
        })->pluck('id');

        // Veterinarios disponibles
        $availableVeterinarians = Veterinary::where('specialty', $specialty)
            ->whereNotIn('id', $veterinarians)
            ->with('user')
            ->get()
            ->map(function ($vet) {
                return [
                    'id' => $vet->id,
                    'name' => $vet->user->name . ' ' . $vet->user->surname,
                ];
            });

        return response()->json($availableVeterinarians);
    }
}