<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Produto;
use App\Models\TipoProduto;
use App\Models\StatusProduto;
use App\Models\Localizacao;
use App\Models\User;
use Illuminate\Support\Str;

class ProdutoSeeder extends Seeder
{
    public function run()
    {
        $tipos = TipoProduto::all();
        $status = StatusProduto::all();
        $localizacoes = Localizacao::all();
        $usuarios = User::all();

        for ($i = 0; $i < 100; $i++) {
            Produto::create([
                'tipo_id' => $tipos->random()->id,
                'status_id' => $status->random()->id,
                'localizacao_id' => $localizacoes->random()->id,
                'user_id' => $usuarios->random()->id,
                'nome' => 'Produto ' . Str::random(10),
                'descricao' => 'Descrição do produto ' . Str::random(20),
                'preco' => rand(100, 1000),
                'quantidade' => rand(1, 100),
                'unidade_medida' => 'unidade',
                'imagem' => '',
            ]);
        }
    }
}
