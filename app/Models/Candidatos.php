<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidatos extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'ultimo_cargo',
        'ultimo_salario',
        'pretensao_salarial_clt',
        'pretensao_salarial_pj',
        'posicao_desejada',
        'escolaridade',
        'graduacao_principal',
        'como_conheceu',
        'consultor_talents',
        'nivel_ingles',
        'qualificacoes_tecnicas',
        'certificacoes',
        'cv',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function processo()
    {
        return $this->hasMany(Processos::class, 'candidato_id');
    }
}
