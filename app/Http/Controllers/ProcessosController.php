<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProcessosRequest;
use App\Models\Processos;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProcessosController extends Controller
{
    public function getProcessos(Request $request)
    {
        try {
            if ($request->query()) {
                $query = Processos::query();

                foreach ($request->query() as $campo => $valor) {
                    if (!empty($valor)) {
                        $query->where($campo, $valor);
                    }
                }

                $processos = $query->get(); // Executa a consulta
                
            } else {
                $processos = Processos::all();
            }

            return response()->json([
                'success' => true,
                'processos' => $processos
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao listar os processos: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getProcessoById(string $id)
    {
        try {
            $processo = Processos::findOrFail($id);

            return response()->json([
                'success' => true,
                'processo' => $processo
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao buscar o processo pelo id: ' . $e->getMessage()
            ], 404);
        }
    }

    public function createProcesso(ProcessosRequest $request)
    {
        try {
            DB::beginTransaction();

            $processo = Processos::create([
                'candidato_id' => $request->candidato_id,
                'vaga_id' => $request->vaga_id,
                'status' => $request->status,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Processo Seletivo criado com sucesso'
            ], 201);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Erro ao criar o processo: ' . $e->getMessage()
            ], 400);
        }
    }

    public function updateProcesso(Request $request, string $id)
    {
        try {
            DB::beginTransaction();

            $processo = Processos::findOrFail($id);

            $processo->update([
                'candidato_id' => $request->candidato_id ?? null,
                'vaga_id' => $request->vaga_id ?? null,
                'status' => $request->status ?? null,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Processo Seletivo atualizado com sucesso'
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Erro ao atualizar o processo: ' . $e->getMessage()
            ], 400);
        }
    }

    public function deleteProcesso(string $id)
    {
        try {
            DB::beginTransaction();
            $processo = Processos::findOrFail($id);
            $processo->delete();
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Processo Seletivo deletado com sucesso'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao deletar o processo: ' . $e->getMessage()
            ], 400);
        }
    }
}
