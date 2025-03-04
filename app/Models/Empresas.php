<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresas extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'cnpj',
        'razao_social',
        'nome_fantasia',
        'segmento',
        'numero_funcionarios',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function vagas()
    {
        return $this->hasMany(Vagas::class, 'empresa_id');
    }

}
