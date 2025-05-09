<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
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
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        //Si los datos no son correctos devolverá un error
        if($validator->fails()){
            return response()->json($validator->errors());
        }

        //Creamos el usuario
        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'role' => 'Cliente',
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        // Guardamos el token en la sesión
        session(['token' => $token]);

        if($user->role === User::ROLE_CLIENT){
            return redirect()->route('cliente.dashboard');
        }else if($user->role === User::ROLE_ADMIN || $user->role === User::ROLE_VET){
            return redirect()->route('admin.dashboard');
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

        if($user->role === User::ROLE_CLIENT){
            return redirect()->route('cliente.dashboard');
        }else if($user->role === User::ROLE_ADMIN || $user->role === User::ROLE_VET){
            return redirect()->route('admin.dashboard');
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