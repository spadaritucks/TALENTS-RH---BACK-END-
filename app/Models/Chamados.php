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

    public function empresa()
    {
        return $this->belongsTo(Empresas::class, 'empresa_id');
    }

    public function profissao()
    {
        return $this->belongsTo(Profissoes::class, 'profissao_id');
    }

    public function chamado_atualizacoes(){
        return $this->hasMany(ChamadosAtualizacoes::class, 'chamados_id');
    }
}
