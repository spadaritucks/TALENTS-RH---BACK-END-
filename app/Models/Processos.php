<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Processos extends Model
{
    use HasFactory;

    protected $fillable = [
        'candidato_id',
        'vaga_id',
        'status',
    ];

    public function candidato() {
        return $this->belongsTo(Candidatos::class, 'candidato_id');
    }

    public function vaga(){
        return $this->belongsTo(Vagas::class, 'vaga_id');
    }
}
