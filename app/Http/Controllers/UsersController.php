<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsersRequest;
use App\Models\Admins;
use App\Models\Candidatos;
use App\Models\Consultores;
use App\Models\Empresas;
use App\Models\Headhunters;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $users = User::all();
            $headhunters = Headhunters::all();
            $candidatos = Candidatos::all();
            $empresas = Empresas::all();
            $consultores = Consultores::all();
            $admins = Admins::all();
            

            return response()->json([
                'status' => true,
                'users' => $users,
                'candidatos' => $candidatos,
                'headhunters' => $headhunters,
                'empresas' => $empresas,
                'consultores' => $consultores,
                'admins' => $admins,
            ]);

        }catch(Exception $e){
            return response()->json([
                'status' => false,
                'message' => 'Erro ao listar os dados do usuario' .$e
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UsersRequest $request)
    {
        
        try{

           
            

            DB::beginTransaction();

            if ($request->hasFile('cv')) {
                $file = $request->file('cv');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = 'uploads/' . $fileName;
                Storage::disk('public')->putFileAs('uploads', $file, $fileName); // Salva o arquivo na pasta storage/app/public/uploads
                $cv = $filePath;
            }

            $usuario = User::create([
                'tipo_usuario' => $request->tipo_usuario,
                'nome' => $request->nome,
                'sobrenome' => $request->sobrenome,
                'email' => $request->email,
                'cidade' => $request->cidade,
                'estado' => $request->estado,
                'celular_1' => $request->celular_1,
                'celular_2' => $request->celular_2,
                'data_nascimento' => $request->data_nascimento,
                'linkedin' => $request->linkedin,
                'password' => Hash::make($request->password) ?? null,
            ]);

            if($request->tipo_usuario === 'candidato'){

                
               $candidato = Candidatos::create([
                    'user_id' => $usuario->id,
                    'ultimo_cargo' => $request->ultimo_cargo,
                    'ultimo_salario' => $request->ultimo_salario,
                    'pretensao_salarial_clt' => $request->pretensao_salarial_clt,
                    'pretensao_salarial_pj' => $request->pretensao_salarial_pj,
                    'posicao_desejada' => $request->posicao_desejada,
                    'escolaridade' => $request->escolaridade,
                    'graduacao_principal' => $request->graduacao_principal,
                    'como_conheceu' => $request->como_conheceu,
                    'consultor_talents' => $request->consultor_talents,
                    'nivel_ingles' => $request->nivel_ingles,
                    'qualificacoes_tecnicas' => $request->qualificacoes_tecnicas,
                    'certificacoes' => $request->certificacoes,
                    'cv' => $cv,
                ]);
            }elseif($request->tipo_usuario === 'headhunter'){

              

                $headhunter = Headhunters::create([
                    'user_id' => $usuario->id,
                    'como_conheceu' => $request->como_conheceu,
                    'situacao' => $request->situacao,
                    'comportamento_description' => $request->comportamento_description,
                    'anos_trabalho' => $request->anos_trabalho,
                    'quantia_vagas' => $request->quantia_vagas,
                    'horas_diarias' => $request->horas_diarias,
                    'dias_semanais' => $request->dias_semanais,
                    'nivel_senioridade' => $request->nivel_senioridade,
                    'segmento' => $request->segmento,
                    'cv' => $cv,
                ]);

            }elseif($request->tipo_usuario === 'empresa'){

                $empresa = Empresas::create([
                    'user_id' => $usuario->id,
                    'cnpj' => $request->cnpj,
                    'razao_social' => $request->razao_social,
                    'nome_fantasia' => $request->nome_fantasia,
                    'segmento' => $request->segmento,
                    'numero_funcionarios' => $request->numero_funcionarios
                ]);

            }elseif($request->tipo_usuario === 'consultor'){
                $consultor = Consultores::create([
                    'user_id' => $usuario->id,
                    'cargo' => $request->cargo,
                    'atividades' => $request->atividades,
                    'cv' => $cv,
                ]);
            }elseif($request->tipo_usuario === "admin"){

                $admin = Admins::create([
                    'user_id' => $usuario->id,
                    'cargo' => $request->cargo,
                    'atividades' => $request->atividades,
                    'cv' => $cv,
                ]);

            }else{
                return response()->json([
                    'status' => false,
                    'message' => 'Tipo de usuario invalido'
                ], 400);
            }

            DB::commit();


            return response()->json([
                'status' => true,
                'message' => 'Usuario cadastrado com sucesso'
            ], 201);

        }catch(Exception $e){
            return response()->json([
                'status' => false,
                'message' => 'Erro ao cadastrar o usuario ' .$e->getMessage()
            ], 500);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
