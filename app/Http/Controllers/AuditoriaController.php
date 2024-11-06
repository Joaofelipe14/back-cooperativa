<?php
namespace App\Http\Controllers;

use App\Models\Auditoria;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuditoriaController extends Controller
{
    public function getAll(Request $request)
    {
        try {
            // Verifica se o usuário autenticado tem permissão
            $userAuth = Auth::user();

            if ($userAuth->tipo_usuario != 'admin') {
                return response()->json([
                    'status' => false,
                    'dados' => ['mensagem' => 'Usuário não autorizado.']
                ], 403);
            }

            $perPage = $request->get('per_page',5); 
            $page = $request->get('page', 1); 
            $tabela = $request->get('tabela'); 
            $dataInicial = $request->get('data_inicial');
            $dataFinal = $request->get('data_final');

            $query = Auditoria::with('user');

            if ($tabela) {
                $query->where('tabela', 'like', "%$tabela%");
            }
            if ($dataInicial && $dataFinal) {
                $query->whereBetween('created_at', [$dataInicial, $dataFinal]);
            }

            $query->orderBy('id', 'desc');
            $auditoria = $query->paginate($perPage, ['*'], 'page', $page);

            return response()->json([
                'status' => true,
                'dados' => $auditoria
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'dados' => [
                    'mensagem' => 'Erro ao buscar auditorias',
                    'erro' => $e->getMessage(),
                ],
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getTabelas()
    {
        try {
            // Consulta as tabelas distintas
            $tabelas = Auditoria::select('tabela')->distinct()->pluck('tabela');

            return response()->json([
                'status' => true,
                'dados' => $tabelas
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'dados' => [
                    'mensagem' => 'Erro ao buscar tabelas',
                    'erro' => $e->getMessage(),
                ],
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

