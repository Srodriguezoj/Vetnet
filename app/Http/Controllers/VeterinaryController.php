<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Veterinary;
use App\Models\Appointment;
use App\Models\Invoice;
use App\Models\Pet;
use App\Http\Controllers\AppointmentController;
use Illuminate\Support\Facades\Hash;
use Validator;
use Illuminate\Support\Facades\Auth;
use \stdClass;
use App\Http\Controllers\AuthController;

class VeterinaryController extends Controller
{
    /**
     * Funcion para mostrar el formulario de crear un usuario con rol 'Veterinario'
     */
    public function create()
    {
        return view('veterinary.createVeterinary');
    }

    /**
     * Funcion para crear un nuevo usuario con rol 'Veterinario'
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|regex:/^[\pL\s\-]+$/u',
            'surname' => 'required|string|max:250|regex:/^[\pL\s\-]+$/u',
            'email' => ['required','string', 'email','max:200','unique:users','regex:/^[^@\s]+@[^@\s]+\.(com|es|org|net|edu|gov|info)$/i',],
            'dni' => ['required','string','size:9','unique:users','regex:/^[0-9]{8}[A-Za-z]$/',],
            'password' => ['required','string','min:8','max:200','confirmed','regex:/[a-z]/','regex:/[A-Z]/','regex:/[0-9]/',],
            'collegiate_num' => 'required|string|max:10|unique:veterinaries,collegiate_num',
            'specialty' => 'required|string',
        ], [
            'dni.regex' => 'El DNI debe tener 8 números y una letra.',
            'email.regex' => 'El correo debe tener un formato válido.',
            'password.regex' => 'La contraseña debe contener al menos una mayúscula, una minúscula y un número.',
            'password.confirmed' => 'La confirmación de la contraseña no coincide.',
        ]);
        $user = User::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'email' => $request->email,
            'dni' => $request->dni,
            'role' => 'Veterinario',
            'password' => Hash::make($request->password),
        ]);
        Veterinary::create([
            'id_user' => $user->id,
            'collegiate_num' => $request->collegiate_num,
            'specialty' => $request->specialty,
        ]);

        return redirect()->route('veterinary.showVeterinaries')->with('success', 'Veterinario creado.');
    }

    /**
     * Funcion para eliminar un usuario con rol de 'Veterinario'
     */
    public function delete($id)
    {
        $veterinary = Veterinary::findOrFail($id);
        $user = $veterinary->user;
        $veterinary->delete();
        $user->delete();

        return redirect()->route('veterinary.showVeterinaries')->with('success', 'Veterinario eliminado.');
    }

    /**
     * Funcion para mostrar los veterinario
     */
    public function index()
    {
        $veterinaries = Veterinary::with('user')->get();

        return view('veterinary.showVeterinaries', compact('veterinaries'));
    }

    /**
     * Funcion para mostrar las citas de un veterinario
     */
    public function showDates()
    {
        $veterinary = Veterinary::where('id_user', auth()->id())->first();
        if (!$veterinary) {
            return redirect()->back()->with('error', 'No estás registrado como veterinario.');
        }
       $appointments = Appointment::where('id_veterinary', $veterinary->id)->with('pet.owner')->get();

        return view('veterinary.showDates', compact('appointments'));
    }

    /**
     * Funcion para mostrar las facturas de los veterinarios
     */
    public function showInvoices()
    {
        $user = Auth::user();
        if ($user->role !== 'Admin') {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $invoices = Invoice::with('veterinary.user')->get();

        return view('veterinary.showInvoices', compact('invoices'));
    }
    /**
     * Funcion para mostrar todas las citas de los veterinarios
     */
    public function showAllDates()
    {
        $appointments = Appointment::all(); 
        
        return view('veterinary.showAllDates', compact('appointments'));
    }
     /**
     * Funcion para mostrar todas las mascotas del programa
     */
    public function showAllPets()
    {
        $pets = Pet::all(); 
        return view('veterinary.showPets', compact('pets'));
    }
    /**
     * Funcion para mostrar una mascota
     */
     public function showPet(Pet $pet)
    {
        return view('veterinary.showPet', compact('pet'));
    }
    /**
     * Funcion para mostrar el historial clinico de una mascota
     */
    public function showPetMedicalRecords(Pet $pet)
    {
        $medicalRecords = $pet->medicalRecords; 
        return view('veterinary.showPetMedicalRecords', compact('pet', 'medicalRecords'));
    }

    // Mostrar las prescripciones adjuntas al historial clinico de una mascota
    public function showPetPrescriptions(Pet $pet)
    {
        $prescriptions = $pet->prescriptions;
        return view('veterinary.showPetPrescriptions', compact('pet', 'prescriptions'));
    }
}
