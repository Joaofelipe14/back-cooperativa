<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;
use Carbon\Carbon;

class GraficoController extends Controller
{
    public function graficoTipo(Request $request)
    {
        try {
            $periodo = $request->input('periodo', '7d');
            $dataInicio = Carbon::now()->subDays((int)str_replace('d', '', $periodo));

            $tipos = Produto::where('created_at', '>=', $dataInicio)
                ->with('tipo')
                ->selectRaw('tipo_id, count(*) as quantidade')
                ->groupBy('tipo_id')
                ->get()
                ->map(function ($produto) {
                    return [
                        'nome' => $produto->tipo ? $produto->tipo->nome : 'Sem Tipo',
                        'quantidade' => $produto->quantidade
                    ];
                });

            return response()->json($tipos);
        } catch (\Exception $e) {
            return response()->json(['erro' => 'Erro ao obter dados para gráfico de tipo', 'detalhes' => $e->getMessage()], 500);
        }
    }

    public function graficoStatus(Request $request)
    {
        try {
            $periodo = $request->input('periodo', '7d');
            $dataInicio = Carbon::now()->subDays((int)str_replace('d', '', $periodo));

            $status = Produto::where('created_at', '>=', $dataInicio)
                ->with('status')
                ->selectRaw('status_id, count(*) as quantidade')
                ->groupBy('status_id')
                ->get()
                ->map(function ($produto) {
                    return [
                        'nome' => $produto->status ? $produto->status->nome : 'Sem Status',
                        'quantidade' => $produto->quantidade
                    ];
                });

            return response()->json($status);
        } catch (\Exception $e) {
            return response()->json(['erro' => 'Erro ao obter dados para gráfico de status', 'detalhes' => $e->getMessage()], 500);
        }
    }

    public function graficoUsuario(Request $request)
    {
        try {
            $periodo = $request->input('periodo', '7d');
            $dataInicio = Carbon::now()->subDays((int)str_replace('d', '', $periodo));

            $usuarios = Produto::where('created_at', '>=', $dataInicio)
                ->with('user')
                ->selectRaw('user_id, count(*) as quantidade, sum(preco) as total_vendido')
                ->groupBy('user_id')
                ->get()
                ->map(function ($produto) {
                    return [
                        'nome' => $produto->user ? $produto->user->name : 'Sem Usuário',
                        'quantidade' => $produto->quantidade,
                        'total_vendido' => $produto->total_vendido
                    ];
                });

            return response()->json($usuarios);
        } catch (\Exception $e) {
            return response()->json(['erro' => 'Erro ao obter dados para gráfico de usuários', 'detalhes' => $e->getMessage()], 500);
        }
    }
}
