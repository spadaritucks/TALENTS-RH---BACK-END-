<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Headhunters extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'como_conheceu',
        'situacao',
        'comportamento_description',
        'anos_trabalho',
        'quantia_vagas',
        'horas_diarias',
        'dias_semanais',
        'nivel_senioridade',
        'segmento',
        'cv',
    ];


    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function vagas () {
        return $this->hasMany(Vagas::class, 'headhunter_id');
    }
}
