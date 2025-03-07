<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChamadoAtualizacoesRequest;
use App\Http\Requests\ChamadosRequest; // Supondo que exista um request para validação
use App\Models\ChamadosAtualizacoes;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChamadoAtualizacoesController extends Controller
{
    public function getAtualizacoes(Request $request)
    {
        try {
            if ($request->query()) {
                $query = ChamadosAtualizacoes::query();

                foreach ($request->query() as $campo => $valor) {
                    if (!empty($valor)) {
                        $query->where($campo, $valor);
                    }
                }

                $atualizacoes = $query->get(); // Executa a consulta
                
            } else {
                $atualizacoes = ChamadosAtualizacoes::all();
            }

            return response()->json([
                'success' => true,
                'atualizacoes' => $atualizacoes
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => "Erro ao consultar as atualizações: " . $e->getMessage()
            ], 500);
        }
    }

    public function getAtualizacaoById(string $id)
    {
        try {
            $atualizacao = ChamadosAtualizacoes::findOrFail($id);

            return response()->json([
                'success' => true,
                'atualizacao' => $atualizacao
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao buscar a atualização pelo id: ' . $e->getMessage()
            ], 404);
        }
    }

    public function createAtualizacao(ChamadoAtualizacoesRequest $request)
    {
        try {
            DB::beginTransaction();

            ChamadosAtualizacoes::create([
                'chamados_id' => $request->chamados_id,
                'user_id' => $request->user_id,
                'titulo' => $request->titulo,
                'atualizacoes' => $request->atualizacoes,
                'anexo' => $request->anexo,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Atualização criada com sucesso'
            ], 201);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Falha ao criar a atualização: ' . $e->getMessage()
            ], 400);
        }
    }

    public function updateAtualizacao(Request $request, string $id)
    {
        try {
            DB::beginTransaction();

            $atualizacao = ChamadosAtualizacoes::findOrFail($id);

            // Atualiza apenas os campos que foram enviados na requisição
            $atualizacao->update($request->only(['chamados_id', 'user_id', 'titulo', 'atualizacoes', 'anexo']));

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Atualização atualizada com sucesso'
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Falha ao atualizar a atualização: ' . $e->getMessage()
            ], 400);
        }
    }

    public function deleteAtualizacao(string $id)
    {
        try {
            DB::beginTransaction();
            $atualizacao = ChamadosAtualizacoes::findOrFail($id);
            $atualizacao->delete();
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Atualização excluída com sucesso'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Falha ao excluir a atualização: ' . $e->getMessage()
            ], 400);
        }
    }
}
