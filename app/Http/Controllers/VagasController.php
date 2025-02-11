<?php

namespace App\Http\Controllers;

use App\Models\Vagas;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VagasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{

            $vagas = Vagas::all();

            return response()->json([
                'status' => true,
                'vagas' => $vagas
            ], 200);

        }catch(Exception $e){
            return response()->json([
                'status' => false,
                'message' => 'Erro ao consultar as vagas' .$e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{

            DB::beginTransaction();

            $vaga = Vagas::create([
                'headhunter_id' => $request->headhunter_id ?? null,
                'admin_id' => $request->admin_id ?? null,
                'empresa_id' => $request->empresa_id,
                'profissao_id'=> $request->profissao_id,
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
                'status' => true,
                'message' => 'Vaga Criada com Sucesso'
            ], 201);

        }catch(Exception $e){
            return response()->json([
                'status' => false,
                'message' => 'Falha ao cadastrar a Vaga' . $e->getMessage()
            ], 400);
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

            $vaga = Vagas::find($id);

            $vaga->update([
                'headhunter_id' => $request->headhunter_id ?? null,
                'admin_id' => $request->admin_id ?? null,
                'empresa_id' => $request->empresa_id,
                'profissao_id'=> $request->profissao_id,
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
                'status' => true,
                'message' => 'Vaga Atualizada com Sucesso'
            ], 200);

        }catch(Exception $e){
            return response()->json([
                'status' => false,
                'message' => 'Erro ao atualizar a vaga' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            
            DB::beginTransaction();

            $vaga = Vagas::find($id);

           
            $vaga->delete();

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Vaga deletada com sucesso'
            ], 200);

        }catch(Exception $e){
            return response()->json([
                'status' => false,
                'message' => 'Erro ao deletar a vaga' . $e->getMessage()
            ], 500);

        }
    }
}
