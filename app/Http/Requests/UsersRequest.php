<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UsersRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => false,
            'message' => $validator->errors(),
        ], 422));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'tipo_usuario' => 'required|string|max:255',
            'nome' => 'required|string|max:255',
            'sobrenome' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'cidade' => 'required|string|max:255',
            'estado' => 'required|string|max:255',
            'celular_1' => 'required|string|max:255',
            'celular_2' => 'nullable|string|max:255',
            'data_nascimento' => 'required|date',
            'linkedin' => 'required|string|max:255',
            'password' => 'required_if:tipo_usuario,in,candidato,headhunter,empresa,admin|string|min:8',

            //Validacoes para candidato
            'ultimo_cargo' => 'required_if:tipo_usuario,candidato|string|max:255',
            'ultimo_salario' => 'required_if:tipo_usuario,candidato',
            'pretensao_salarial_clt' => 'required_if:tipo_usuario,candidato',
            'pretensao_salarial_pj' => 'required_if:tipo_usuario,candidato',
            'posicao_desejada' => 'required_if:tipo_usuario,candidato|string|max:255',
            'escolaridade' => 'required_if:tipo_usuario,candidato|string|max:255',
            'graduacao_principal' => 'required_if:tipo_usuario,candidato|string|max:255',
            'como_conheceu' => 'required_if:tipo_usuario,candidato|string|max:255',
            'consultor_talents' => 'required_if:tipo_usuario,candidato|string|max:255',
            'nivel_ingles' => 'required_if:tipo_usuario,candidato|string|max:255',
            'qualificacoes_tecnicas' => 'required_if:tipo_usuario,candidato|string|max:255',
            'certificacoes' => 'required_if:tipo_usuario,candidato|string|max:255',
            'cv' => 'required_if:tipo_usuario,candidato|file|mimes:pdf|max:2048',

            //Validacoes para headhunter
            'como_conheceu' => 'required_if:tipo_usuario,headhunter|string|max:255',
            'situacao' => 'required_if:tipo_usuario,headhunter|string|max:255',
            'comportamento_description' => 'required_if:tipo_usuario,headhunter|string|max:255',
            'anos_trabalho' => 'required_if:tipo_usuario,headhunter',
            'quantia_vagas' => 'required_if:tipo_usuario,headhunter',
            'horas_diarias' => 'required_if:tipo_usuario,headhunter',
            'dias_semanais' => 'required_if:tipo_usuario,headhunter',
            'nivel_senioridade' => 'required_if:tipo_usuario,headhunter|string|max:255',
            'segmento' => 'required_if:tipo_usuario,headhunter|string|max:255',
            'cv' => 'required_if:tipo_usuario,headhunter|file|mimes:pdf|max:2048',

            //Validacoes para empresa
            'cnpj' => 'required_if:tipo_usuario,empresa|string|max:255',
            'razao_social' => 'required_if:tipo_usuario,empresa|string|max:255',
            'nome_fantasia' => 'required_if:tipo_usuario,empresa|string|max:255',
            'segmento' => 'required_if:tipo_usuario,empresa|string|max:255',
            'numero_funcionarios' => 'required_if:tipo_usuario,empresa',
            

        ];
    }
}
