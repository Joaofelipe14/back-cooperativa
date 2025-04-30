<?php

namespace App\Http\Controllers;

use App\Models\Localizacao;
use App\Models\TipoProduto;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TipoProdutoController extends Controller
{
    public function index()
    {
        try {
            $registros = TipoProduto::orderBy('id', 'desc')->get();

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
