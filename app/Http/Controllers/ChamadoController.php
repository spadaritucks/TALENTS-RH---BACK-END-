<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChamadosRequest; // Supondo que exista um request para validação
use App\Models\Chamados;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChamadoController extends Controller
{
    public function getChamados(Request $request)
    {
        try {
            if ($request->query()) {
                $query = Chamados::query();

                foreach ($request->query() as $campo => $valor) {
                    if (!empty($valor)) {
                        $query->where($campo, $valor);
                    }
                }

                $chamados = $query->get(); // Executa a consulta
                
            } else {
                $chamados = Chamados::all();
            }

            return response()->json([
                'success' => true,
                'chamados' => $chamados
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => "Erro ao consultar os chamados: " . $e->getMessage()
            ], 500);
        }
    }

    public function getChamadoById(string $id)
    {
        try {
            $chamado = Chamados::findOrFail($id);

            return response()->json([
                'success' => true,
                'chamado' => $chamado
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao buscar o chamado pelo id: ' . $e->getMessage()
            ], 404);
        }
    }

    public function createChamado(ChamadosRequest $request)
    {
        try {
            DB::beginTransaction();

            Chamados::create([
                'empresa_id' => $request->empresa_id,
                'profissao_id' => $request->profissao_id,
                'numero_vagas' => $request->numero_vagas,
                'descricao' => $request->descricao,
                'status' => $request->status,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Chamado criado com sucesso'
            ], 201);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Falha ao criar o chamado: ' . $e->getMessage()
            ], 400);
        }
    }

    public function updateChamado(Request $request, string $id)
    {
        try {
            DB::beginTransaction();

            $chamado = Chamados::findOrFail($id);

            // Atualiza apenas os campos que foram enviados na requisição
            $chamado->update($request->only(['empresa_id', 'profissao_id','headhunter_id', 'numero_vagas', 'descricao', 'status']));

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Chamado atualizado com sucesso'
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Falha ao atualizar o chamado: ' . $e->getMessage()
            ], 400);
        }
    }

    public function deleteChamado(string $id)
    {
        try {
            DB::beginTransaction();
            $chamado = Chamados::findOrFail($id);
            $chamado->delete();
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Chamado excluído com sucesso'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Falha ao excluir o chamado: ' . $e->getMessage()
            ], 400);
        }
    }
}
