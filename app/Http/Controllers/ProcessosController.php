<?php

namespace App\Http\Controllers;

use App\Models\Processos;
use Exception;
use Illuminate\Http\Request;

class ProcessosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $processos = Processos::all();

            return response()->json([
                'status' => true,
                'processos' => $processos
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Erro ao listar os processos' . $e->getMessage()
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $processo = Processos::create([
                'candidato_id' => $request->candidato_id,
                'vaga_id' => $request->vaga_id,
                'status' => $request->status,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Processo Seletivo criado com sucesso'
            ]);
        } catch(Exception $e){
            return response()->json([
                'status' => false,
                'message' => 'Erro ao criar o processo' . $e->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try{
            $processo = Processos::findOrFail($id);

            $processo->update([
                'candidato_id' => $request->candidato_id ?? null,
                'vaga_id' => $request->vaga_id ??null,
                'status' => $request->status ?? null,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Processo Seletivo atualizado com sucesso'
            ]);
        } catch(Exception $e){
            return response()->json([
                'status' => false,
                'message' => 'Erro ao atualizar o processo' . $e->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            $processo = Processos::findOrFail($id);

            $processo->delete();

            return response()->json([
                'status' => true,
                'message' => 'Processo Seletivo deletado com sucesso'
            ]);
        } catch(Exception $e){
            return response()->json([
                'status' => false,
                'message' => 'Erro ao deletar o processo' . $e->getMessage()
            ]);
        }
    }
}
