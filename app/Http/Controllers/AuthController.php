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

        //Devolvemos la respueta en formato json con la info del usuario, el token de acceso y el tipo de token
        return response()->json(['data'=>$user,'access_token'=>$token,'token_type'=>'Bearer']);
    }


    //login de usuario
    public function login(Request $request){

        //Si el email o el password no son correctos...
        if(!Auth::attempt($request->only('email', 'password'))){
            //Se envia una respuesta informaco de que no estamos autorizados
            return response()->json(['message'=>'Unauthorized'], 401);
        }

        //Si la autenticación ha tenido éxito, se busca al usuario en la BBDD
        $user = User::where('email', $request['email'])->firstOrFail();

        //Se crea el token para la sesión
        $token = $user->createToken('auth_token')->plainTextToken;

        //Se devuelve la respuesta con la información
        return response()->json([
            'message'=> 'Hi '.$user->name,
            'access_token'=> $token,
            'token_type' => 'Bearer',
            'user'=>$user,
        ]);
    }

    public function logout(){
        auth()->user()->tokens()->delete();

        return['message'=>'Logout with exit. Token was deleted'];
    }



}