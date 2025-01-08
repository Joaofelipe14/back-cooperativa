<?php

namespace App\Http\Controllers;

use App\Models\Auditoria;
use App\Models\Cooperativa;
use App\Models\RegistroFinanceiro;
use App\Models\RegistroPesca;
use App\Models\RegistroVenda;
use Illuminate\Http\Request;

class ResultadoMapaController extends Controller
{
    public function getResultadoMapa()
    {
        try {
            $pescaRegistros = RegistroPesca::with(['user', 'localizacao'])->get();
            $vendaRegistros = RegistroVenda::with(['user', 'localizacao'])->get();

            $registrosUnificados = $pescaRegistros->map(function ($registro) {
                return [
                    'lat' => floatval($registro->localizacao->latitude),
                    'lng' => floatval($registro->localizacao->longitude),
                    'pescado' => $registro->pescado,
                    'quantidade' => $registro->quantidade,
                    'type' => 'pesca',
                    'address' => $registro->localizacao->descricao_amigavel,
                    'user_name' => $registro->user->name,
                    'user_id' => $registro->user->id
                ];
            });

            $vendaRegistrosUnificados = $vendaRegistros->map(function ($registro) {
                return [
                    'lat' => floatval($registro->localizacao->latitude),
                    'lng' => floatval($registro->localizacao->longitude),
                    'pescado' => $registro->pescado,
                    'quantidade' => $registro->quantidade,
                    'type' => 'venda',
                    'address' => $registro->localizacao->descricao_amigavel,
                    'valor' =>number_format($registro->valor, 2, ',', '.'),
                    'user_name' => $registro->user->name,
                    'user_id' => $registro->user->id
                ];
            });

            $todosRegistros = $registrosUnificados->merge($vendaRegistrosUnificados);

            return response()->json([
                'status' => true,
                'dados' => $todosRegistros
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'dados' => [
                    'mensagem' => 'Erro ao buscar tabelas',
                    'erro' => $e->getMessage(),
                ],
            ]);
        }
    }
}
