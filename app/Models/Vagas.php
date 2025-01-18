<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vagas extends Model
{
    use HasFactory;


    protected $fillable = [
        'headhunter_id',
        'empresa_id',
        'profissao_id',
        'titulo',
        'descricao',
        'competencias',
        'nivel_senioridade',
        'tipo_salario',
        'salario_minimo',
        'salario_maximo',
        'data_final',
        'status'
    ];
}
