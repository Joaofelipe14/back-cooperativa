<?php

namespace App\Http\Controllers;

use App\Models\Auditoria;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuditoriaController extends Controller
{

    public function getAll()
    {
        try {

            $userAuth = Auth::user();

            if ($userAuth->tipo_usuario != 'admin') {
                return response()->json([
                    'status' => false,
                    'dados' => ['mensagem' => 'Usuário não autorizado.']
                ], 403);
            }
            $auditoria = Auditoria::with('user')->get();

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
}
