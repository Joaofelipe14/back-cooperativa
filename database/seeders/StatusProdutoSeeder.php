<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StatusProduto;

class StatusProdutoSeeder extends Seeder
{
    public function run()
    {
        $status = ['Ativo', 'Inativo', 'Vendido'];

        foreach ($status as $s) {
            StatusProduto::create(['nome' => $s]);
        }
    }
}