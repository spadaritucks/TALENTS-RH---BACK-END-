<?php

namespace App\Http\Controllers;

use App\Models\Profissoes;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfissoesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {

            $profissoes = Profissoes::all();

            return response()->json([
                'status' => true,
                'profissoes' => $profissoes
            ]);
        } catch (Exception $e) {

            return response()->json([
                'status' => false,
                'message' => 'Erro ao listar as profissões' . $e->getMessage()
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            DB::beginTransaction();

            $profissao = Profissoes::create([
                'nome' => $request->nome
            ]);


            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Profissão criada com sucesso'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Erro ao criar a profissão' . $e->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try{
            DB::beginTransaction();

            $profissao = Profissoes::find($id);

            $profissao->update([
                'nome' => $request->nome
            ]);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Profissão atualizada com sucesso'
            ]);

        }catch(Exception $e){
            return response()->json([
                'status' => false,
                'message' => 'Erro ao atualizar a profissão' . $e->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            DB::beginTransaction();

            $profissao = Profissoes::find($id);


            $profissao->delete();

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Profissão deletada com sucesso'
            ]);

        }catch(Exception $e){
            return response()->json([
                'status' => false,
                'message' => 'Erro ao deletar a profissão' . $e->getMessage()
            ]);
        }
    }
}
