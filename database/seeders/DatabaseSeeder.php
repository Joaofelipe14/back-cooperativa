<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            LocalizacaoTableSeeder::class,
            // Adicione outros seeders aqui
            UsersTableSeeder::class,
            CooperativaSeeder::class,
            TipoProdutoSeeder::class,
            StatusProdutoSeeder::class,
        ]);
    }
}
