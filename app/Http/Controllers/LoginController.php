<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(LoginRequest $request){
       
        if(Auth::attempt($request->only('email', 'password'))){
            return response()->json([
                'success' => true,
                'token' => $request->user()->createToken('api_token')->plainTextToken,
                'user' => $request->user(),
                'message' => 'Login realizado com sucesso'
            ], 200);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Email ou senha inválidos'
            ], 401);
        }
    }
}
