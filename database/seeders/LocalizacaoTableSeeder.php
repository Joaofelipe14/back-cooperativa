<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocalizacaoTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('localizacao')->insert([
            ['id' => 1, 'descricao' => 'Praia do Leste', 'descricao_amigavel' => 'Praia bonita', 'latitude' => '-23.5505', 'longitude' => '-46.6333', 'created_at' => '2024-10-16 17:15:50', 'updated_at' => '2024-10-16 17:15:50'],
            ['id' => 2, 'descricao' => 'corotaoa', 'descricao_amigavel' => 'cidade dde casa', 'latitude' => '10', 'longitude' => '11', 'created_at' => '2024-10-16 17:34:36', 'updated_at' => '2024-10-16 17:34:36'],
            ['id' => 3, 'descricao' => 'R. Pref. Milton Improta, 444 - Vila Maria, São Paulo - SP, 02119-021, Brasil', 'descricao_amigavel' => 'ponte', 'latitude' => '-23.51256995152', 'longitude' => '-46.591929608154', 'created_at' => '2024-10-18 00:22:04', 'updated_at' => '2024-10-18 00:22:04'],
            ['id' => 4, 'descricao' => 'R. Joli, 591 - Brás, São Paulo - SP, 03016-020, Brasil', 'descricao_amigavel' => 'ponte da rua', 'latitude' => '-23.535707008001', 'longitude' => '-46.61304395752', 'created_at' => '2024-10-18 00:28:05', 'updated_at' => '2024-10-18 00:28:05'],
            ['id' => 5, 'descricao' => 'Rua Senador Leite, 563, Coroatá - MA, 65415-000, Brasil', 'descricao_amigavel' => 'Minha casa', 'latitude' => '-4.1288402077538', 'longitude' => '-44.121508722368', 'created_at' => '2024-10-18 00:33:10', 'updated_at' => '2024-10-18 00:33:10'],
            ['id' => 6, 'descricao' => 'Filipinho, São Luís - MA, Brasil', 'descricao_amigavel' => 'lalio', 'latitude' => '-2.5544133', 'longitude' => '-44.2656672', 'created_at' => '2024-10-18 01:09:38', 'updated_at' => '2024-10-18 01:09:38'],
            ['id' => 7, 'descricao' => 'Coroatá, MA, 65415-000, Brasil', 'descricao_amigavel' => 'Rio Itapecuru', 'latitude' => '-4.1283394', 'longitude' => '-44.130317', 'created_at' => '2024-10-18 19:28:17', 'updated_at' => '2024-10-18 19:28:17'],
        ]);
    }
}
