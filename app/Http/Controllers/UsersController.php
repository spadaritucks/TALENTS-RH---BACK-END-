<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function getAllUsers(Request $request)
    {
        try {
           $users = User::all();

            return response()->json([
                'success' => true,
                'users' => $users,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao listar os dados do usuário: ' . $e->getMessage()
            ]);
        }
    }
}
