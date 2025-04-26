<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TipoProduto;

class TipoProdutoSeeder extends Seeder
{
    public function run()
    {
        $tipos = ['Peixe', 'Camarão', 'Marisco', 'Casca de Coco'];

        foreach ($tipos as $tipo) {
            TipoProduto::create(['nome' => $tipo]);
        }
    }
}