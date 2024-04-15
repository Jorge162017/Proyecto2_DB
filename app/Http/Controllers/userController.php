<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use  App\Models\User;
use Illuminate\Support\Facades\Validator;

class userController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(\App\Models\User $user)
    {
        return $user->paginate(2);
    }



      
    public function __construct(\App\Models\User $user){
        $this->user = $user;
    }



    public function login(Request $request){
        // Crear el validador para las credenciales de entrada
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6'
        ]);
    
        // Verificar si la validación falla
        if ($validator->fails()) {
            // Devolver una respuesta con los errores de validación
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        // Capturar los datos validados
        $credentials = $request->only('email', 'password');
        
        // Intentar autenticar al usuario
        if (! $token = Auth::attempt($credentials)) {
            // Autenticación fallida
            return response()->json(['message' => 'usuario o contraseña incorrecta'], 401);
        }
    
        // Autenticación exitosa
        return $this->respondWithToken($token);
    }


    public function register(Request $request){
        // Definir las reglas de validación
        $rules = [
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'telefono' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed'
        ];
    
        // Crear el validador con el request y las reglas
        $validator = Validator::make($request->all(), $rules);
    
        // Chequear si la validación falla
        if ($validator->fails()) {
            // Devolver una respuesta con los errores
            return response()->json(['errors' => $validator->errors()], 400);
        }
    
        try {
            // Crear el usuario si la validación fue exitosa
            $user = new User;
            
            $user->nombre = $request->input('nombre');
            $user->apellido = $request->input('apellido');
            $user->telefono = $request->input('telefono');
            $user->email = $request->input('email');
            $user->rolid = 2; //mesero
            $user->password = app('hash')->make($request->input('password'));
    
            $user->save();
    
            // Devolver respuesta exitosa
            return response()->json(['user' => $user, 'message' => 'usuario creado con exito'], 201);
        } catch (\Exception $e) {
            // Log de la excepción
            error_log($e);
            return response()->json(['message' => 'no se ha podido crear el usuario'], 409);
        }
    }
   
}
