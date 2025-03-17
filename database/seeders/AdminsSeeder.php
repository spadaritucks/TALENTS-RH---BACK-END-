<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Admins;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;

class AdminsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'tipo_usuario' => 'admin',
            'foto_usuario' => 'caminho/para/foto.jpg',
            'nome' => 'Thiago Henrique',
            'sobrenome' => 'Spadari de Oliveira',
            'email' => 'thiago.spadari02@gmail.com',
            'cep' => '09725140',
            'logradouro' => 'Rua Leiria',
            'numero' => '3',
            'cidade' => 'São Bernardo do Campo',
            'bairro' => 'Vila Lusitânia',
            'latitude' => -23.71130615,
            'longitude' => -46.557337149999995,
            'estado' => 'SP',
            'celular_1' => '(11) 960599793',
            'celular_2' => '(11) 960599793',
            'data_nascimento' => '2002-11-29',
            'linkedin' => 'https://www.linkedin.com/in/thiago-spadari-41b95120b/',
            'password' =>  Hash::make('titi9632'),
        ]);

        // Criar um admin associado ao usuário
        Admins::create([
            'user_id' => $user->id,
            'cargo' => 'Desenvolvedor Full Stack',
            'atividades' => 'Responsavel geral pelo sistema da talents hub',
            'cv' => 'caminho/para/cv.pdf',
        ]);
    }
}
