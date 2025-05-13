<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pet;
use App\Models\User;
use App\Http\Controllers\AuthController;
use App\Models\Veterinary;
use App\Models\Appointment;
use App\Models\Prescription;
use App\Models\MedicalRecord;
use App\Models\PetVaccination;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Validator;
use Illuminate\Support\Facades\Auth;
use \stdClass;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PetController extends Controller
{
    /**
     * Muestra el formulario para crear una mascota
     */
    public function create()
    {
        return view('pets.createPet');  
    }

    /**
     * Funcion para crear una nueva mascota
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'num_microchip' => 'required|string|max:15|unique:pets',
            'date_of_birth' => 'required|date',
            'sex' => 'required|in:Macho,Hembra',
            'species' => 'required|in:Perro,Gato,Huron',
            'breed' => 'required|string|max:300',
            'colour' => 'required|string|max:200',
            'coat' => 'required|string|max:150',
            'size' => 'required|in:Grande,Mediano,Pequeño',
            'weight' => 'required|numeric',
        ]);
        Pet::create([
            'id_owner' => auth()->id(),
            'num_microchip' => $request->num_microchip,
            'name' => $request->name,
            'date_of_birth' => $request->date_of_birth,
            'sex' => $request->sex,
            'species' => $request->species,
            'breed' => $request->breed,
            'colour' => $request->colour,
            'coat' => $request->coat,
            'size' => $request->size,
            'weight' => $request->weight,
        ]);

        
        return redirect()->route('client.dashboard')->with('success', 'Mascota registrada exitosamente');
    }

    /**
     * Funcion para mostra el formulario de editar una mascota
     */
    public function edit($petId)
    {
        $pet = Pet::findOrFail($petId);

        return view('client.editPet', compact('pet'));
    }

    /**
     * Funcion para editar una mascota
     */
    public function update(Request $request, $petId)
    {
        $validated = $request->validate([
            'num_microchip' => 'nullable|string|max:50',
            'name' => 'required|string|max:100',
            'date_of_birth' => 'nullable|date',
            'sex' => 'nullable|string|max:10',
            'species' => 'nullable|string|max:100',
            'breed' => 'nullable|string|max:100',
            'colour' => 'nullable|string|max:50',
            'coat' => 'nullable|string|max:50',
            'size' => 'nullable|string|max:50',
            'weight' => 'nullable|numeric',
        ]);
        $pet = Pet::findOrFail($petId);
        $pet->update([
            'num_microchip' => $request->num_microchip,
            'name' => $request->name,
            'date_of_birth' => $request->date_of_birth,
            'sex' => $request->sex,
            'species' => $request->species,
            'breed' => $request->breed,
            'colour' => $request->colour,
            'coat' => $request->coat,
            'size' => $request->size,
            'weight' => $request->weight,
        ]);

        return redirect()->route('client.showPet', ['pet' => $pet->id])->with('success', 'Información de la mascota actualizada correctamente.');
    }

    /**
     * Funcion para mostrar la informacion de una mascota
     */
    public function show($id)
    {
        $pet = Pet::with(['medicalRecords', 'appointments'])->findOrFail($id);

        return view('client.showPet', compact('pet'));
    }

    /**
     * Funcion para mostrar el historial clinico de una mascota
     */
    public function showMedicalRecords(Pet $pet)
    {
        $medicalRecords = MedicalRecord::with('invoice.items')->where('id_pet', $pet->id)->get();

        return view('client.showMedicalRecords', compact('pet', 'medicalRecords'));
    }
}
