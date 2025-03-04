<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Admins;
use Faker\Factory as Faker;

class AdminsSeeder extends Seeder
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
                'tipo_usuario' => 'admin',
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

            // Criar um admin associado ao usuário
            Admins::create([
                'user_id' => $user->id,
                'cargo' => $faker->word(),
                'atividades' => $faker->sentence(),
                'cv' => $faker->text(),
            ]);
        }
    }
}
