<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class VagasRequest extends FormRequest
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
            'headhunter_id' => 'nullable|exists:headhunters,id',
            'admin_id' => 'nullable|exists:admins,id',
            'empresa_id' => 'required|exists:empresas,id',
            'profissao_id' => 'required|exists:profissoes,id',
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string|max:1000',
            'competencias' => 'nullable|string|max:1000',
            'nivel_senioridade' => 'required|string|max:100',
            'tipo_salario' => 'required|string|max:50',
            'salario_minimo' => 'nullable|numeric',
            'salario_maximo' => 'nullable|numeric',
            'status' => 'required|string|max:50',
            'data_final' => 'required|date',
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
