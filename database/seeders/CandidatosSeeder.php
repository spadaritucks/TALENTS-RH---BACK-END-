<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Candidatos;
use Faker\Factory as Faker;

class CandidatosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 10; $i++) {
            // Criar um usuário
            $user = User::create([
                'tipo_usuario' => 'candidato',
                'foto_usuario' => $faker->imageUrl(),
                'nome' => $faker->firstName(),
                'sobrenome' => $faker->lastName(),
                'email' => $faker->unique()->safeEmail(),
                'cep' => $faker->postcode(),
                'logradouro' => $faker->streetAddress(),
                'numero' => $faker->buildingNumber(),
                'cidade' => $faker->city(),
                'bairro' => $faker->word(),
                'latitude' => $faker->latitude(),
                'longitude' => $faker->longitude(),
                'estado' => $faker->state(),
                'celular_1' => $faker->phoneNumber(),
                'celular_2' => $faker->phoneNumber(),
                'data_nascimento' => $faker->date(),
                'linkedin' => $faker->url(),
                'password' => bcrypt('password'), // Senha padrão
            ]);

            // Criar um candidato associado ao usuário
            Candidatos::create([
                'user_id' => $user->id,
                'ultimo_cargo' => $faker->jobTitle(),
                'ultimo_salario' => $faker->randomFloat(2, 2000, 10000),
                'pretensao_salarial_clt' => $faker->randomFloat(2, 2000, 10000),
                'pretensao_salarial_pj' => $faker->randomFloat(2, 2000, 10000),
                'posicao_desejada' => $faker->jobTitle(),
                'escolaridade' => $faker->word(),
                'graduacao_principal' => $faker->word(),
                'como_conheceu' => $faker->word(),
                'consultor_talents' => $faker->word(),
                'nivel_ingles' => $faker->word(),
                'qualificacoes_tecnicas' => $faker->sentence(),
                'certificacoes' => $faker->sentence(),
                'cv' => $faker->text(),
            ]);
        }
    }
}
