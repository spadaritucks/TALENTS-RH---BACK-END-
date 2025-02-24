<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CandidatosRequest extends FormRequest
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
            'tipo_usuario' => 'required|string',
            'foto_usuario' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'nome' => 'required|string|max:255',
            'sobrenome' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'cep' => 'required|string|max:10',
            'logradouro' => 'required|string|max:255',
            'numero' => 'required|string|max:10',
            'cidade' => 'required|string|max:100',
            'latitude' => 'required|string',
            'longitude' => 'required|string',
            'estado' => 'required|string|max:100',
            'celular_1' => 'required|string|max:15',
            'celular_2' => 'nullable|string|max:15',
            'data_nascimento' => 'required|date',
            'linkedin' => 'nullable|url|max:255',
            'ultimo_cargo' => 'required|string|max:100',
            'ultimo_salario' => 'required|numeric',
            'pretensao_salarial_clt' => 'required|numeric',
            'pretensao_salarial_pj' => 'required|numeric',
            'posicao_desejada' => 'required|string|max:100',
            'escolaridade' => 'required|string|max:100',
            'graduacao_principal' => 'required|string|max:100',
            'como_conheceu' => 'required|string|max:255',
            'consultor_talents' => 'required|string|max:100',
            'nivel_ingles' => 'required|string|max:50',
            'qualificacoes_tecnicas' => 'nullable|string',
            'certificacoes' => 'nullable|string',
            'password' => 'required|string|min:6',
        ];
    }
}
