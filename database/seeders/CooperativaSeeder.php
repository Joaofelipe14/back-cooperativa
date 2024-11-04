<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class CooperativaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        DB::table('cooperativa')->insert([
            'nome' => $faker->company,
            'endereco' => $faker->address,
            'cep' => $faker->postcode,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
