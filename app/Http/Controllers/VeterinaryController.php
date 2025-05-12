<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Veterinary;
use App\Models\Appointment;
use App\Models\Invoice;
use App\Http\Controllers\AppointmentController;
use Illuminate\Support\Facades\Hash;
use Validator;
use Illuminate\Support\Facades\Auth;
use \stdClass;
use App\Http\Controllers\AuthController;

class VeterinaryController extends Controller
{
    public function create()
    {
        return view('veterinary.createVeterinary');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'collegiate_num' => 'required|string|unique:veterinaries,collegiate_num',
            'specialty' => 'required|string',
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

        return redirect()->route('veterinary.showVeterinaries')->with('success', 'Veterinario creado correctamente.');
    }

    public function delete($id)
    {
        $veterinary = Veterinary::findOrFail($id);

        $user = $veterinary->user;
        $veterinary->delete();

        $user->delete();

        return redirect()->route('veterinary.showVeterinaries')->with('success', 'Veterinario eliminado correctamente.');
    }

    public function index()
    {
        $veterinaries = Veterinary::with('user')->get();
        return view('veterinary.showVeterinaries', compact('veterinaries'));
    }

    public function showDates()
    {
        $veterinary = Veterinary::where('id_user', auth()->id())->first();

        if (!$veterinary) {
            return redirect()->back()->with('error', 'No estás registrado como veterinario.');
        }

       $appointments = Appointment::where('id_veterinary', $veterinary->id)->with('pet.owner')->get();

        return view('veterinary.showDates', compact('appointments'));
    }

    public function showInvoices()
    {
        $invoices = Invoice::with('veterinary.user')->get();
        return view('veterinary.showInvoices', compact('invoices'));
    }
    public function showAllDates()
    {
        $appointments = Appointment::all(); 
        return view('veterinary.showAllDates', compact('appointments'));
    }
}
