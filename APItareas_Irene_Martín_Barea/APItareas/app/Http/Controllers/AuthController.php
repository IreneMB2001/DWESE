<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //
    public function register(Request $request){
        //Crear un nuevo usuario en la base de datos usando el modelo User
        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            //hashear la contraseña para que se guarde de forma segura
            'password'=>Hash::make($request->password)
        ]);
        //Crear un token de acceso para el usuario recién registrado
        $token = $user->createToken('auth_token')->plainTextToken;

        //Devuelve una respuesta json con los detalles del usuario y el token de acceso
        return response()->json(['data'=>$user, 'access_token'=>$token, 
        'token_type'=>'Bearer']); //tipo de autenicación
    }

    public function logout(){
        // Revocar y eliminar todos los tokens de acceso asociados al usuario autenticado
        auth()->user()->tokens()->delete();
        // Devolver un mensaje de sesión cerrada
        return ['message' =>'Sesión cerrada correctamente'];
    }

    public function login(Request $request){
        // Buscar al usuario en la base de datos por su dirección de correo electrónico
        $user = User::where('email', $request->email)->firstOrFail();

        // Verificar si la contraseña proporcionada y hasheada no coincide con la contraseña 
        //almacenada en la base de datos
        if(!Hash::check($request->password, $user->password)){
            //devuelve mensaje de error en json si no coinciden
            return response()->json(['message'=> 'Credenciales incorrectas'], 401);
        }

        //crear un nuevo token de acceso para el usuario autenticado
        $token = $user->createToken('auth_token')->plainTextToken;

        //Devuelve respuesta json con los detalles de usuario y un mensaje de saludo
        return response()->json(['message'=>'Hola ' . $user->name,
                                'access_token'=>$token,
                                'token_type'=>'Bearer']);
    }
}
