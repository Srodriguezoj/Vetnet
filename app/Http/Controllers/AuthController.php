<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pet;
use Illuminate\Support\Facades\Hash;
use Validator;
use Illuminate\Support\Facades\Auth;
use \stdClass;

class AuthController extends Controller
{
    /**
     * Registra un nuevo usuario por defecto esto solo sirve para
     * los clientes que se registren ellos mismos
     */
    public function register(Request $request)
    {
       $request->validate([
            'name' => 'required|string|max:100|regex:/^[\pL\s\-]+$/u',
            'surname' => 'required|string|max:250|regex:/^[\pL\s\-]+$/u',
            'email' => 'required|string|email|max:200|unique:users',
            'dni' => ['required','string','max:15','unique:users','regex:/^\d{8}[A-Za-z]$/'],
            'phone' => ['nullable','string','max:20','regex:/^\d{9}$/'],
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:200|regex:/^[\pL\s\-]+$/u',
            'country' => 'nullable|string|max:200|regex:/^[\pL\s\-]+$/u',
            'postcode' => ['nullable','string','max:5'],
            'password' => ['required','string','min:8','max:200','confirmed','regex:/[a-z]/','regex:/[A-Z]/','regex:/[0-9]/',],
        ]);

        $user = User::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'email' => $request->email,
            'dni' => $request->dni,
            'phone' => $request->phone,
            'address' => $request->address,
            'city' => $request->city,
            'country' => $request->country,
            'postcode' => $request->postcode,
            'password' => Hash::make($request->password),
            'role' => 'Cliente',
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;
        session(['token' => $token]);

        return redirect()->route('client.dashboard');
    }

    /**
     * Funcion de login donde segun el rol redirige a una ruta u otra
     */
    public function login(Request $request){

        if(!Auth::attempt($request->only('email', 'password'))){
            return back()->withErrors(['email' => 'Email o contraseña incorrectos']);
        }
        $user = User::where('email', $request['email'])->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;
        session(['token' => $token]);

        if($user->role === User::ROLE_CLIENT){
            return redirect()->route('client.dashboard');
        }else if($user->role === User::ROLE_VET){
            return redirect()->route('veterinary.showDates');
        }else if($user->role === User::ROLE_ADMIN){
                return redirect()->route('veterinary.dashboard');
        }else{
            return redirect('/');
        }
    }

    /**
     * Funcion de logout para todos los usuarios
     */
    public function logout(){
        auth()->user()->tokens()->delete();
        session()->flush();

        return redirect()->route('login');
    }


}