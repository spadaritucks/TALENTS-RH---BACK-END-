<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'tipo_usuario',
        'foto_usuario',
        'nome',
        'sobrenome',
        'email',
        'cep',
        'logradouro',
        'numero',
        'cidade',
        'bairro',
        'latitude',
        'longitude',
        'estado',
        'celular_1',
        'celular_2',
        'data_nascimento',
        'linkedin',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function empresa()
    {
        return $this->hasOne(Empresas::class, 'user_id');
    }

    public function headhunter(){
        return $this->hasOne(Headhunters::class, 'user_id');
    }

    public function candidatos() {
        return $this->hasOne(Candidatos::class, 'user_id');
    }

    public function admins() {
        return $this->hasOne(Admins::class, 'user_id');
    }

    public function consultores() {
        return $this->hasOne(Consultores::class, 'user_id');
    }
// ... 



    


}
