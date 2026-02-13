<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    //Registro
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:250',
            'email' => 'required|string|max:250|unique:users,email',
            'password' => 'required|string|min:8|confirmed'
        ]);
        
        if($validator->fails()){
            return response()->json([
                'success' => false,
                'error' => $validator->errors(),
                'message' => 'Error al registrar el usuario'
            ], 422);
        }
        User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password'))
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Usuario registrado exitosamente'
        ], 201);
    }

    //Login
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email' => 'required|string|email|max:250',
            'password' => 'required|string|min:8'
        ]);
        
        if($validator->fails()){
            return response()->json([
                'success' => false,
                'error' => $validator->errors(),
                'message' => 'Error al registrar el usuario'
            ], 422);
        }
        $credentials = $request->only('email', 'password');

        try {
            if (!$token = JWTAuth::attempt($credentials)){
                return response()->json([
                    'success' => false,
                    'message' => 'Credenciales invalidas'
                ], 401);
            }
            return response()->json([
                'success' => true,
                'token' => $token,
                'user' => Auth::user()
            ], 200);
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'message' => 'No se pudo crear el token',
                'error' => $e->getMessage()
            ], 500);
            
        }
        

    }

    //Obtener usuario
    public function getUser(){
        $user = Auth::user();
        return response()->json([
            'success' => true,
            'data' => $user
        ], 200);
    }

    //Cerrar sesión
    public function logout(){
        JWTAuth::invalidate(JWTAuth::getToken());
        return response()->json([
            'success' => true,
            'message' => 'Se ha terminado la sesión exitosamente'
        ], 200);
    }
}
