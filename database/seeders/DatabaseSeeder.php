<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            LocalizacaoTableSeeder::class,
            TipoProdutoSeeder::class,
            StatusProdutoSeeder::class,
            UsersTableSeeder::class,
            CooperativaSeeder::class,
            ProdutoSeeder::class
        
            
        ]);
    }
}
