<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProcessosRequest extends FormRequest
{
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

    public function rules(): array
    {
        return [
            'candidato_id' => 'required|exists:users,id', // Verifica se o candidato existe
            'vaga_id' => 'required|exists:vagas,id', // Verifica se a vaga existe
            'status' => 'required|string|max:100',
        ];
    }
}