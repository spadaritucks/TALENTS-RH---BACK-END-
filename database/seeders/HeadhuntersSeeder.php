<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Headhunters;
use Faker\Factory as Faker;

class HeadhuntersSeeder extends Seeder
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
                'tipo_usuario' => 'headhunter',
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

            // Criar um headhunter associado ao usuário
            Headhunters::create([
                'user_id' => $user->id,
                'como_conheceu' => $faker->word(),
                'situacao' => $faker->word(),
                'comportamento_description' => $faker->sentence(),
                'anos_trabalho' => $faker->numberBetween(1, 20),
                'quantia_vagas' => $faker->numberBetween(1, 10),
                'horas_diarias' => $faker->numberBetween(1, 8),
                'dias_semanais' => $faker->numberBetween(1, 7),
                'nivel_senioridade' => $faker->word(),
                'segmento' => $faker->word(),
                'cv' => $faker->text(),
            ]);
        }
    }
} 