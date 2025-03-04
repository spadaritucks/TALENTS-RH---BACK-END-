<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Empresas;
use Faker\Factory as Faker;

class EmpresasSeeder extends Seeder
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
                'tipo_usuario' => 'empresa',
                'foto_usuario' => $faker->imageUrl(),
                'nome' => $faker->company(),
                'sobrenome' => '', // Sobrenome não aplicável para empresas
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
                'data_nascimento' => $faker->date(), // Não aplicável para empresas
                'linkedin' => $faker->url(),
                'password' => bcrypt('password'), // Senha padrão
            ]);

            // Criar uma empresa associada ao usuário
            Empresas::create([
                'user_id' => $user->id,
                'cnpj' => $faker->unique()->numerify('##.###.###/####-##'),
                'razao_social' => $faker->company(),
                'nome_fantasia' => $faker->companySuffix(),
                'segmento' => $faker->word(),
                'numero_funcionarios' => $faker->numberBetween(1, 500),
            ]);
        }
    }
}
