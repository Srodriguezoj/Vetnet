<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pet;
use Illuminate\Support\Facades\Hash;
use Validator;
use Illuminate\Support\Facades\Auth;
use \stdClass;
use App\Http\Controllers\AuthController;

class UserController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $user = Auth::user();

        if ($user->hasRole('Cliente')) {
            return view('client.showClient', compact('user'));
        }

        if ($user->role == 'Admin' || $user->role == 'Veterinario') {
            return view('veterinary.showProfile', compact('user'));
        }

        abort(403);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        $user = Auth::user();

        if ($user->hasRole('Cliente')) {
            return view('client.editClient', compact('user'));
        }

        if ($user->role == 'Admin' || $user->role == 'Veterinario') {
            return view('veterinary.editProfile', compact('user'));
        }

        abort(403);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
            $validated = $request->validate([
            'name' => 'required|string|max:100',
            'surname' => 'required|string|max:250',
            'email' => 'required|email|max:200|unique:users,email,' . auth()->id(),
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:200',
            'country' => 'nullable|string|max:200',
            'postcode' => 'nullable|string|max:20',
        ]);

        $user = auth()->user();
        $user->update($validated);

        if ($user->hasRole('Cliente')) {
            return redirect()->route('client.showClient')->with('success', 'Perfil actualizado con éxito');
        }

        if ($user->role == 'Admin' || $user->role == 'Veterinario') {
            return redirect()->route('veterinary.showProfile')->with('success', 'Perfil actualizado con éxito');
        }

        abort(403);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, auth()->user()->password)) {
            return back()->withErrors(['current_password' => 'La contraseña actual no es válida.']);
        }

        auth()->user()->update([
            'password' => Hash::make($request->new_password),
        ]);

        $user = auth()->user(); 

        if ($user->role == 'Cliente') {
            return redirect()->route('client.showClient')->with('success', 'Perfil actualizado con éxito');
        }

        if ($user->role == 'Admin' || $user->role == 'Veterinario') {
           return redirect()->route('veterinary.showProfile')->with('success', 'Contraseña actualizada correctamente.');
        }

        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


   public function showPets()
    {
        if (auth()->user()->role !== 'Cliente') {
            abort(403);
        }

        $pets = auth()->user()->pets;
        return view('client.dashboard', compact('pets'));
    }

}
