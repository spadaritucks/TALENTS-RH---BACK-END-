<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminsRequest;
use App\Models\Admins;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminsController extends Controller
{
    public function getAdmins(Request $request)
{
    try {
        if ($request->query()) {
            $query = User::query()->where('tipo_usuario', 'admin');

            foreach ($request->query() as $campo => $valor) {
                if (!empty($valor)) {
                    $query->where($campo, $valor);
                }
            }

            $users = $query->get(); // Executa a consulta
            $admins = Admins::where('user_id', $users->first()->id)->get();
        }else{
            $users = User::where('tipo_usuario', 'admin')->get();
            $admins = Admins::all();
        }

        return response()->json([
            'success' => true,
            'users' => $users,
            'admins' => $admins,
        ]);
    } catch (Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Erro ao listar os dados do usuário: ' . $e->getMessage()
        ]);
    }
}

    public function getAdminById(string $id)
    {
        try {
            $user = User::findOrFail($id);
            $admin = Admins::where('user_id', $id)->firstOrFail();

            return response()->json([
                'success' => true,
                'user' => $user,
                'admin' => $admin,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao buscar o admin pelo id: ' . $e->getMessage()
            ]);
        }
    }

    public function createAdmin(AdminsRequest $request)
    {
        try {
            DB::beginTransaction();

            if ($request->hasFile('foto_usuario')) {
                $file = $request->file('foto_usuario');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = 'uploads/' . $fileName;
                Storage::disk('public')->putFileAs('uploads', $file, $fileName);
                $fotoUsuario = $filePath;
            }

            if ($request->hasFile('cv')) {
                $file = $request->file('cv');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = 'uploads/' . $fileName;
                Storage::disk('public')->putFileAs('uploads', $file, $fileName); // Salva o arquivo na pasta storage/app/public/uploads
                $cv = $filePath;
            }

            $usuario = User::create([
                'tipo_usuario' => 'admin',
                'foto_usuario' => $fotoUsuario,
                'nome' => $request->nome,
                'sobrenome' => $request->sobrenome,
                'email' => $request->email,
                'cep' => $request->cep,
                'logradouro' => $request->logradouro,
                'numero' => $request->numero,
                'cidade' => $request->cidade,
                'bairro' => $request->bairro,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'estado' => $request->estado,
                'celular_1' => $request->celular_1,
                'celular_2' => $request->celular_2,
                'data_nascimento' => $request->data_nascimento,
                'linkedin' => $request->linkedin,
                'password' => Hash::make($request->password),
            ]);

            $admin = Admins::create([
                'user_id' => $usuario->id,
                'cargo' => $request->cargo,
                'atividades' => $request->atividades,
                'cv' => $cv,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Admin cadastrado com sucesso'
            ], 201);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Erro ao cadastrar o admin: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateAdmin(Request $request, string $id)
    {
        try {
            DB::beginTransaction();

            $user = User::findOrFail($id);
            $admin = Admins::where('user_id', $id)->firstOrFail();

            $user->update($request->only([
                'nome',
                'sobrenome',
                'email',
                'cep',
                'logradouro',
                'numero',
                'cidade',
                'bairro',
                'latitude',
                'longitude',
                'estado',
                'celular_1',
                'celular_2',
                'data_nascimento',
                'linkedin'
            ]));

            $admin->update($request->only(['cargo', 'atividades']));

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Admin atualizado com sucesso'
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Erro ao atualizar o admin: ' . $e->getMessage()
            ], 500);
        }
    }

    public function deleteAdmin(string $id)
    {
        try {
            $user = User::findOrFail($id);
            $admin = Admins::where('user_id', $id)->firstOrFail();

            $user->delete();
            $admin->delete();

            return response()->json([
                'success' => true,
                'message' => 'Admin deletado com sucesso'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao deletar o admin: ' . $e->getMessage()
            ], 500);
        }
    }
}
