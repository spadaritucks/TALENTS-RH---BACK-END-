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
}
