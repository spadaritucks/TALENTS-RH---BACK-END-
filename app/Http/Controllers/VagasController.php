<?php

namespace App\Http\Controllers;

use App\Http\Requests\VagasRequest; // Supondo que exista um request para validação
use App\Models\Vagas;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VagasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getVagas(Request $request)
    {
        try {
            if ($request->query()) {
                $query = Vagas::query();

                foreach ($request->query() as $campo => $valor) {
                    if (!empty($valor)) {
                        $query->where($campo, $valor);
                    }
                }

                $vagas = $query->get(); // Executa a consulta

            } else {
                $vagas = Vagas::all();
            }

            return response()->json([
                'success' => true,
                'vagas' => $vagas
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao consultar as vagas: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function createVaga(VagasRequest $request)
    {
        try {
            DB::beginTransaction();

            $vaga = Vagas::create([
                'headhunter_id' => $request->headhunter_id ?? null,
                'admin_id' => $request->admin_id ?? null,
                'empresa_id' => $request->empresa_id,
                'profissao_id' => $request->profissao_id,
                'titulo' => $request->titulo,
                'descricao' => $request->descricao,
                'competencias' => $request->competencias,
                'nivel_senioridade' => $request->nivel_senioridade,
                'tipo_salario' => $request->tipo_salario,
                'salario_minimo' => $request->salario_minimo ?? null,
                'salario_maximo' => $request->salario_maximo ?? null,
                'status' => $request->status,
                'data_final' => $request->data_final
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Vaga criada com sucesso'
            ], 201);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Falha ao cadastrar a vaga: ' . $e->getMessage()
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function getVagaById(string $id)
    {
        try {
            $vaga = Vagas::findOrFail($id);

            return response()->json([
                'success' => true,
                'vaga' => $vaga
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao buscar a vaga pelo id: ' . $e->getMessage()
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateVaga(Request $request, string $id)
    {
        try {
            DB::beginTransaction();

            $vaga = Vagas::findOrFail($id);

            // Atualiza apenas os campos que foram enviados na requisição
            $vaga->update($request->only(['headhunter_id', 'admin_id', 'empresa_id', 'profissao_id', 'titulo', 'descricao', 'competencias', 'nivel_senioridade', 'tipo_salario', 'salario_minimo', 'salario_maximo', 'status', 'data_final']));

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Vaga atualizada com sucesso'
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Erro ao atualizar a vaga: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function deleteVaga(string $id)
    {
        try {
            DB::beginTransaction();

            $vaga = Vagas::findOrFail($id);
            $vaga->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Vaga deletada com sucesso'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao deletar a vaga: ' . $e->getMessage()
            ], 500);
        }
    }
}
