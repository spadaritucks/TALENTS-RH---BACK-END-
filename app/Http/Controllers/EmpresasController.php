<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmpresasRequest; // Certifique-se de criar este Request
use App\Models\Empresas;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class EmpresasController extends Controller
{
    public function getEmpresas(Request $request)
    {
        try {
            if ($request->query()) {
                $query = User::query()->where('tipo_usuario', 'empresa');
    
                foreach ($request->query() as $campo => $valor) {
                    if (!empty($valor)) {
                        $query->where($campo, $valor);
                    }
                }
    
                $users = $query->get(); // Executa a consulta
                $empresas = Empresas::where('user_id', $users->first()->id)->get();
            }else{
                $users = User::where('tipo_usuario', 'empresa')->get();
                $empresas = Empresas::all();
            }

            return response()->json([
                'success' => true,
                'users' => $users,
                'empresas' => $empresas,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao listar os dados do usuário: ' . $e->getMessage()
            ]);
        }
    }

    public function getEmpresaById(string $id)
    {
        try {
            $user = User::findOrFail($id);
            $empresa = Empresas::where('user_id', $id)->firstOrFail();

            return response()->json([
                'success' => true,
                'user' => $user,
                'empresa' => $empresa,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao buscar a empresa pelo id: ' . $e->getMessage()
            ]);
        }
    }

    public function createEmpresa(EmpresasRequest $request)
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

            $usuario = User::create([
                'tipo_usuario' => $request->tipo_usuario,
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

            $empresa = Empresas::create([
                'user_id' => $usuario->id,
                'cnpj' => $request->cnpj,
                'razao_social' => $request->razao_social,
                'nome_fantasia' => $request->nome_fantasia,
                'segmento' => $request->segmento,
                'numero_funcionarios' => $request->numero_funcionarios,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Empresa cadastrada com sucesso'
            ], 201);

        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Erro ao cadastrar a empresa: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateEmpresa(Request $request, string $id)
    {
        try {
            DB::beginTransaction();

            $user = User::findOrFail($id);
            $empresa = Empresas::where('user_id', $id)->firstOrFail();

            $user->update($request->only([
                'nome', 'sobrenome', 'email', 'cep', 'logradouro', 'numero',
                'cidade', 'latitude', 'longitude', 'estado', 'celular_1', 'celular_2', 'data_nascimento', 'linkedin'
            ]));

            if ($request->hasFile('foto_usuario')) {
                $file = $request->file('foto_usuario');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = 'uploads/' . $fileName;
                Storage::disk('public')->putFileAs('uploads', $file, $fileName);
                $user->update(['foto_usuario' => $filePath]);
            }

            $empresa->update($request->only([
                'cnpj', 'razao_social', 'nome_fantasia', 'segmento', 'numero_funcionarios'
            ]));

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Empresa atualizada com sucesso'
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Erro ao atualizar a empresa: ' . $e->getMessage()
            ], 500);
        }
    }

    public function deleteEmpresa(string $id)
    {
        try {
            $user = User::findOrFail($id);
            $empresa = Empresas::where('user_id', $id)->firstOrFail();

            $user->delete();
            $empresa->delete();

            return response()->json([
                'success' => true,
                'message' => 'Empresa deletada com sucesso'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao deletar a empresa: ' . $e->getMessage()
            ], 500);
        }
    }
}
