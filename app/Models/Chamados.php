<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chamados extends Model
{
    use HasFactory;

    protected $fillable = [
        'empresa_id',
        'profissao_id',
        'numero_vagas',
        'descricao',
        'status'
        
    ];

}
