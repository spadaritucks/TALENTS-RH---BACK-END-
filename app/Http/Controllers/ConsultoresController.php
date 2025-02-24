<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConsultoresRequest;
use App\Models\Consultores;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ConsultoresController extends Controller
{
    public function getConsultores(Request $request)
    {
        try {
            if ($request->query()) {
                $query = User::query();
    
                foreach ($request->query() as $campo => $valor) {
                    if (!empty($valor)) {
                        $query->where($campo, $valor);
                    }
                }
    
                $users = $query->get(); // Executa a consulta
                $consultores = Consultores::where('user_id', $users->first()->id)->get();
            }else{
                $users = User::where('tipo_usuario', 'consultor')->get();
                $consultores = Consultores::all();
            }

            return response()->json([
                'success' => true,
                'users' => $users,
                'consultores' => $consultores,

            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao listar os dados do usuario' . $e
            ], 400);
        }
    }

    public function getConsultorById(string $id)
    {
        try {
            $user = User::findOrFail($id);
            $consultor = Consultores::where('user_id', $id)->firstOrFail();

            return response()->json([
                'success' => true,
                'user' => $user,
                'consultor' => $consultor,

            ],200);
        } catch (Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Erro ao buscar o consultor pelo id' . $e
            ],400);
        }
    }

    public function createConsultor(ConsultoresRequest $request)
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
            if($request->hasFile('foto_usuario')){
                $file = $request->file('foto_usuario');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = 'uploads/' . $fileName;
                Storage::disk('public')->putFileAs('uploads', $file, $fileName); // Salva o arquivo na pasta storage/app/public/uploads
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
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'estado' => $request->estado,
                'celular_1' => $request->celular_1,
                'celular_2' => $request->celular_2,
                'data_nascimento' => $request->data_nascimento,
                'linkedin' => $request->linkedin,
                'password' => Hash::make($request->password) ?? null,
            ]);

            $consultor = Consultores::create([
                'user_id' => $usuario->id,
                'cargo' => $request->cargo,
                'atividades' => $request->atividades,
                'cv' => $cv,
            ]);


            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Consultor cadastrado com sucesso'

            ], 201);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Erro ao cadastrar o usuario ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateConsultor(Request $request, string $id)
    {
        try {
            DB::beginTransaction();

            $user = User::findOrFail($id);
            $consultor = Consultores::where('user_id', $id)->firstOrFail();

            
            // Atualiza apenas os campos que foram enviados na requisição
            $user->update($request->only([
              'nome', 'sobrenome', 'email', 'cep', 'logradouro', 'numero',
                'cidade','latitude','longitude', 'estado', 'celular_1', 'celular_2', 'data_nascimento', 'linkedin'
            ]));

            $consultor->update($request->only(['cargo','atividades', ]));

            if($request->hasfile('foto_usuario')){
                $file = $request->file('cv');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = 'uploads/' . $fileName;
                Storage::disk('public')->putFileAs('uploads', $file, $fileName);

                $user->update([
                    'foto_usuario' => $filePath
                ]);
            }

            // Atualiza o arquivo de CV, se enviado
            if ($request->hasFile('cv')) {
                $file = $request->file('cv');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = 'uploads/' . $fileName;
                Storage::disk('public')->putFileAs('uploads', $file, $fileName);

                $consultor->update([
                    'cv' => $filePath
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Consultor atualizado com sucesso'
            ], 200);
            
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Erro ao atualizar o consultor: ' . $e->getMessage()
            ], 500);
        }
    }


    public function deleteConsultor(string $id)
    {

        try {
            $user = User::findOrFail($id);
            $consultor = Consultores::where('user_id', $id);

            $user->delete();
            $consultor->delete();

            return response()->json([
                'success' => true,
                'message' => 'Consultor deletado com sucesso'
            ], 200);
        } catch (Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Erro ao deletar o consultor ' . $e->getMessage()
            ], 500);
        }
    }
}
