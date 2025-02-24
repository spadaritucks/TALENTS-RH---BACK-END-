<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfissoesRequest; // Supondo que exista um request para validação
use App\Models\Profissoes;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfissoesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getProfissoes(Request $request)
    {
        try {
            if ($request->query()) {
                $query = Profissoes::query();

                foreach ($request->query() as $campo => $valor) {
                    if (!empty($valor)) {
                        $query->where($campo, $valor);
                    }
                }

                $profissoes = $query->get(); // Executa a consulta

            } else {
                $profissoes = Profissoes::all();
            }

            return response()->json([
                'success' => true,
                'profissoes' => $profissoes
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao listar as profissões: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function createProfissao(ProfissoesRequest $request)
    {
        try {
            DB::beginTransaction();

            $profissao = Profissoes::create([
                'nome' => $request->nome
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Profissão criada com sucesso'
            ], 201);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Erro ao criar a profissão: ' . $e->getMessage()
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function getProfissaoById(string $id)
    {
        try {
            $profissao = Profissoes::findOrFail($id);

            return response()->json([
                'success' => true,
                'profissao' => $profissao
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao buscar a profissão pelo id: ' . $e->getMessage()
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateProfissao(Request $request, string $id)
    {
        try {
            DB::beginTransaction();

            $profissao = Profissoes::findOrFail($id);

            // Atualiza apenas os campos que foram enviados na requisição
            $profissao->update($request->only(['nome']));

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Profissão atualizada com sucesso'
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Erro ao atualizar a profissão: ' . $e->getMessage()
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function deleteProfissao(string $id)
    {
        try {
            DB::beginTransaction();

            $profissao = Profissoes::findOrFail($id);
            $profissao->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Profissão deletada com sucesso'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao deletar a profissão: ' . $e->getMessage()
            ], 400);
        }
    }
}
