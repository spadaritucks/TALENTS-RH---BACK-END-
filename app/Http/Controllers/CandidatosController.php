<?php

namespace App\Http\Controllers;

use App\Http\Requests\CandidatosRequest; // Certifique-se de criar este Request
use App\Models\Candidatos;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class CandidatosController extends Controller
{
    public function getCandidatos(Request $request)
    {
        try {

            if ($request->query()) {
                $query = User::query()->where('tipo_usuario', 'candidato');

                foreach ($request->query() as $campo => $valor) {
                    if (!empty($valor)) {
                        $query->where($campo, $valor);
                    }
                }

                $users = $query->get(); // Executa a consulta
                $candidatos = Candidatos::where('user_id', $users->first()->id)->get();
            }else{
                $users = User::where('tipo_usuario', 'candidato')->get();
                $candidatos = Candidatos::all();
            }

            return response()->json([
                'success' => true,
                'users' => $users,
                'candidatos' => $candidatos,

            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao listar os dados do usuário: ' . $e->getMessage()
            ]);
        }
    }

    public function getCandidatoById(string $id)
    {
        try {
            $user = User::findOrFail($id);
            $candidato = Candidatos::where('user_id', $id)->firstOrFail();

            return response()->json([
                'success' => true,
                'user' => $user,
                'candidato' => $candidato,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao buscar o candidato pelo id: ' . $e->getMessage()
            ]);
        }
    }

    public function createCandidato(CandidatosRequest $request)
    {
        try {
            DB::beginTransaction();

            if ($request->hasFile('cv')) {
                $file = $request->file('cv');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = 'uploads/' . $fileName;
                Storage::disk('public')->putFileAs('uploads', $file, $fileName); // Salva o arquivo na pasta storage/app/public/uploads
                $cv = $filePath;
            }

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

            $candidato = Candidatos::create([
                'user_id' => $usuario->id,
                'ultimo_cargo' => $request->ultimo_cargo,
                'ultimo_salario' => $request->ultimo_salario,
                'pretensao_salarial_clt' => $request->pretensao_salarial_clt,
                'pretensao_salarial_pj' => $request->pretensao_salarial_pj,
                'posicao_desejada' => $request->posicao_desejada,
                'escolaridade' => $request->escolaridade,
                'graduacao_principal' => $request->graduacao_principal,
                'como_conheceu' => $request->como_conheceu,
                'consultor_talents' => $request->consultor_talents,
                'nivel_ingles' => $request->nivel_ingles,
                'qualificacoes_tecnicas' => $request->qualificacoes_tecnicas,
                'certificacoes' => $request->certificacoes,
                'cv' => $cv,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Candidato cadastrado com sucesso'
            ], 201);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Erro ao cadastrar o candidato: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateCandidato(Request $request, string $id)
    {
        try {
            DB::beginTransaction();

            $user = User::findOrFail($id);
            $candidato = Candidatos::where('user_id', $id)->firstOrFail();

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

            $candidato->update($request->only([
                'ultimo_cargo',
                'ultimo_salario',
                'pretensao_salarial_clt',
                'pretensao_salarial_pj',
                'posicao_desejada',
                'escolaridade',
                'graduacao_principal',
                'como_conheceu',
                'consultor_talents',
                'nivel_ingles',
                'qualificacoes_tecnicas',
                'certificacoes'
            ]));

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Candidato atualizado com sucesso'
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Erro ao atualizar o candidato: ' . $e->getMessage()
            ], 500);
        }
    }

    public function deleteCandidato(string $id)
    {
        try {
            $user = User::findOrFail($id);
            $candidato = Candidatos::where('user_id', $id)->firstOrFail();

            $user->delete();
            $candidato->delete();

            return response()->json([
                'success' => true,
                'message' => 'Candidato deletado com sucesso'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao deletar o candidato: ' . $e->getMessage()
            ], 500);
        }
    }
}
