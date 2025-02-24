<?php

namespace App\Http\Controllers;

use App\Http\Requests\HeadhuntersRequest; // Certifique-se de criar este Request
use App\Models\Headhunters;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class HeadhuntersController extends Controller
{
    public function getHeadhunters(Request $request)
    {
        try {
            if ($request->query()) {
                $query = User::query()->where('tipo_usuario', 'headhunter');

                foreach ($request->query() as $campo => $valor) {
                    if (!empty($valor)) {
                        $query->where($campo, $valor);
                    }
                }

                $users = $query->get(); // Executa a consulta
                $headhunters = Headhunters::where('user_id', $users->first()->id)->get();
            } else {
                $users = User::where('tipo_usuario', 'headhunter')->get();
                $headhunters = Headhunters::all();
            }

            return response()->json([
                'success' => true,
                'users' => $users,
                'headhunters' => $headhunters,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao listar os dados do usuário: ' . $e->getMessage()
            ]);
        }
    }

    public function getHeadhunterById(string $id)
    {
        try {
            $user = User::findOrFail($id);
            $headhunter = Headhunters::where('user_id', $id)->firstOrFail();

            return response()->json([
                'success' => true,
                'user' => $user,
                'headhunter' => $headhunter,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao buscar o headhunter pelo id: ' . $e->getMessage()
            ]);
        }
    }

    public function createHeadhunter(HeadhuntersRequest $request)
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
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'estado' => $request->estado,
                'celular_1' => $request->celular_1,
                'celular_2' => $request->celular_2,
                'data_nascimento' => $request->data_nascimento,
                'linkedin' => $request->linkedin,
                'password' => Hash::make($request->password),
            ]);

            $headhunter = Headhunters::create([
                'user_id' => $usuario->id,
                'como_conheceu' => $request->como_conheceu,
                'situacao' => $request->situacao,
                'comportamento_description' => $request->comportamento_description,
                'anos_trabalho' => $request->anos_trabalho,
                'quantia_vagas' => $request->quantia_vagas,
                'horas_diarias' => $request->horas_diarias,
                'dias_semanais' => $request->dias_semanais,
                'nivel_senioridade' => $request->nivel_senioridade,
                'segmento' => $request->segmento,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Headhunter cadastrado com sucesso'
            ], 201);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Erro ao cadastrar o headhunter: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateHeadhunter(Request $request, string $id)
    {
        try {
            DB::beginTransaction();

            $user = User::findOrFail($id);
            $headhunter = Headhunters::where('user_id', $id)->firstOrFail();

            $user->update($request->only([
                'nome',
                'sobrenome',
                'email',
                'cep',
                'logradouro',
                'numero',
                'cidade',
                'latitude',
                'longitude',
                'estado',
                'celular_1',
                'celular_2',
                'data_nascimento',
                'linkedin'
            ]));

            $headhunter->update($request->only([
                'como_conheceu',
                'situacao',
                'comportamento_description',
                'anos_trabalho',
                'quantia_vagas',
                'horas_diarias',
                'dias_semanais',
                'nivel_senioridade',
                'segmento'
            ]));

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Headhunter atualizado com sucesso'
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Erro ao atualizar o headhunter: ' . $e->getMessage()
            ], 500);
        }
    }

    public function deleteHeadhunter(string $id)
    {
        try {
            $user = User::findOrFail($id);
            $headhunter = Headhunters::where('user_id', $id)->firstOrFail();

            $user->delete();
            $headhunter->delete();

            return response()->json([
                'success' => true,
                'message' => 'Headhunter deletado com sucesso'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao deletar o headhunter: ' . $e->getMessage()
            ], 500);
        }
    }
}
