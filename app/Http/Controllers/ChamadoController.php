<?php

namespace App\Http\Controllers;

use App\Models\Chamados;
use App\Models\ChamadosAtualizacoes;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ChamadoController extends Controller
{
    public function index()
    {

        try {

            $chamado = Chamados::all();

            return response()->json([
                'status' => true,
                'chamados' => $chamado
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => "Erro ao consultar os chamados " . $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
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
                'status' => true,
                'message' => 'Chamado criado com sucesso'
            ], 201);
        } catch (Exception $e) {

            return response()->json([
                'status' => false,
                'message' => 'Falha ao criar o chamado ' . $e->getMessage()
            ], 401);
        }
    }

    public function update(Request $request, string $id)
    {

        try {

            DB::beginTransaction();

            $chamado = Chamados::findOrFail($id);

            $chamado->update([
                'empresa_id' => $request->empresa_id ?? null,
                'profissao_id' => $request->profissao_id,
                'numero_vagas' => $request->numero_vagas,
                'descricao' => $request->descricao,
                'status' => $request->status,
            ]);


            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Chamado atualizado com sucesso'
            ], 200);
        } catch (Exception $e) {

            return response()->json([
                'status' => false,
                'message' => 'Falha ao criar o chamado ' . $e->getMessage()
            ], 401);
        }
    }

    public function destroy(string $id)
    {
        try {

            DB::beginTransaction();
            $chamado = Chamados::findOrFail($id);
            $chamado->delete();
            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Chamado excluido com sucesso'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Falha ao excluir o chamado ' . $e->getMessage()
            ], 401);
        }
    }

    public function IndexAtualizacoes()
    {
        try {
            $atualizacoes = ChamadosAtualizacoes::all();

            return response()->json([
                'status' => true,
                'atualizacoes' => $atualizacoes
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Falha ao consultar as atualizacoes ' . $e->getMessage()
            ], 401);
        }
    }

    public function StoreAtualizacoes(Request $request)
    {
        try {

            DB::beginTransaction();

            if ($request->hasFile('anexo')) {
                $file = $request->file('anexo');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = 'uploads/' . $fileName;
                Storage::disk('public')->putFileAs('uploads', $file, $fileName); // Salva o arquivo na pasta storage/app/public/uploads
                $anexo = $filePath;
            }

            $atualizacao = ChamadosAtualizacoes::create([
                'chamados_id' => $request->chamados_id,
                'user_id' => $request->user_id,
                'titulo' => $request->titulo,
                'atualizacoes' => $request->atualizacoes,
                'anexo' => $anexo ?? null
            ]);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Atualizacao criada com sucesso'
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Falha ao criar a atualizacao ' . $e->getMessage()
            ], 401);
        }
    }

    public function UpdateAtualizacoes(Request $request, string $id)
    {
        try {

            if ($request->hasFile('anexo')) {
                $file = $request->file('anexo');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = 'uploads/' . $fileName;
                Storage::disk('public')->putFileAs('uploads', $file, $fileName); // Salva o arquivo na pasta storage/app/public/uploads
                $anexo = $filePath;
            }

            DB::beginTransaction();

            $atualizacao = ChamadosAtualizacoes::findOrFail($id);
            $atualizacao->update([
                'user_id' => $request->user_id,
                'titulo' => $request->titulo ?? null,
                'atualizacoes' => $request->atualizacoes ?? null,
                'anexo' => $anexo ?? null
            ]);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Atualizacao atualizada com sucesso'
            ]);
        } catch (Exception $e) {

            return response()->json([
                'status' => false,
                'message' => 'Falha ao atualizar a atualizacao ' . $e->getMessage()
            ], 401);
        }
    }

    public function DestroyAtualizacoes(string $id)
    {
        try {

            DB::beginTransaction();

            $atualizacao = ChamadosAtualizacoes::findOrFail($id);
            $atualizacao->delete();

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Atualizacao excluida com sucesso'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Falha ao excluir a atualizacao ' . $e->getMessage()
            ], 401);
        }
    }
}
