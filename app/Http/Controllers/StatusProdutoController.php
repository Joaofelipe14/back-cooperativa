<?php

namespace App\Http\Controllers;

use App\Models\StatusProduto;
use Illuminate\Http\Response;

class StatusProdutoController extends Controller
{
    public function index()
    {
        try {
            $registros = StatusProduto::get();

            return response()->json([
                'status' => true,
                'dados' => [
                    'registros' => $registros,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'dados' => [
                    'mensagem' => 'Erro ao obter todos os registros de localização',
                    'erro' => $e->getMessage(),
                ],
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    
}
