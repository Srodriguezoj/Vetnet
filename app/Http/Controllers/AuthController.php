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
    //Registro de usuario
    public function register(Request $request)
    {
        //Validamos los datos que nos llegan de la petición
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

        //Creamos el usuario
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

        // Guardamos el token en la sesión
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


    //login de usuario
    public function login(Request $request){

        //Si el email o el password no son correctos...
        if(!Auth::attempt($request->only('email', 'password'))){
            //Se envia una respuesta informaco de que no estamos autorizados
            return back()->withErrors(['email' => 'Email o contraseña incorrectos']);
        }

        //Si la autenticación ha tenido éxito, se busca al usuario en la BBDD
        $user = User::where('email', $request['email'])->firstOrFail();

        //Se crea el token para la sesión
        $token = $user->createToken('auth_token')->plainTextToken;

        // Guardamos el token en la sesión
        session(['token' => $token]);

        //Redirigimos a la pantalla según el tipo de usuario
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

    public function logout(){
        // Borramos todos los tokens del usuario
        auth()->user()->tokens()->delete();
         // Limpiamos la sesión
        session()->flush();
        return redirect()->route('login');
    }



}