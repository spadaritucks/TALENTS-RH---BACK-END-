<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChamadosAtualizacoes extends Model
{
    use HasFactory;

    protected $fillable = [
        'chamados_id',
        'user_id',
        'titulo',
        'atualizacoes',
        'anexo'
    ];

    protected $table = 'chamado_atualizacoes';

    public function chamado(){
        return $this->belongsTo(Chamados::class, 'chamados_id');
    }
    
}


