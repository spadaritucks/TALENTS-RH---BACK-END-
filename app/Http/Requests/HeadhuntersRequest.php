<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class HeadhuntersRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
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
            'como_conheceu' => 'required|string|max:255',
            'situacao' => 'required|string|max:100',
            'comportamento_description' => 'nullable|string|max:1000',
            'anos_trabalho' => 'required|integer|min:0',
            'quantia_vagas' => 'required|integer|min:1',
            'horas_diarias' => 'required|integer|min:1',
            'dias_semanais' => 'required|integer|min:1',
            'nivel_senioridade' => 'required|string|max:100',
            'segmento' => 'required|string|max:100',
            'password' => 'required|string|min:6',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => false,
            'message' => $validator->errors(),
        ], 422));
    }
}
