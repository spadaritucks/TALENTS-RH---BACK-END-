<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if(Auth::attempt($request->only('email', 'password'))){
            return response()->json([
                'status' => true,
                'token' => $request->user()->createToken('api_token')->plainTextToken,
                'user' => $request->user(),
                'message' => 'Login realizado com sucesso'
            ], 200);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Email ou senha inválidos'
            ], 401);
        }
    }
}
