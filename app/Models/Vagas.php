<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vagas extends Model
{
    use HasFactory;


    protected $fillable = [
        'headhunter_id',
        'admin_id',
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

    public function empresa()
    {
        return $this->belongsTo(Empresas::class, 'empresa_id');
    }

    public function headhunter(){
        return $this->belongsTo(Headhunters::class, 'headhunter_id');
    }

    public function admin(){
        return $this->belongsTo(Admins::class, 'admin_id');
    }

    public function profissao(){
        return $this->belongsTo(Profissoes::class, 'profissao_id');
    }
}
