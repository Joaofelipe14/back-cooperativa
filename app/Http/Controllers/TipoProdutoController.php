<?php

namespace App\Http\Controllers;

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
                    'mensagem' => 'Erro ao obter os registros de tipos de produto',
                    'erro' => $e->getMessage(),
                ],
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nome' => 'required|string|max:255',
            ]);

            $tipoProduto = TipoProduto::create([
                'nome' => $request->nome,
            ]);

            return response()->json([
                'status' => true,
                'dados' => [
                    'mensagem' => 'Tipo de produto criado com sucesso!',
                    'tipo_produto' => $tipoProduto,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'dados' => [
                    'mensagem' => 'Erro ao criar o tipo de produto',
                    'erro' => $e->getMessage(),
                ],
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'nome' => 'required|string|max:255',
            ]);

            $tipoProduto = TipoProduto::find($id);

            if (!$tipoProduto) {
                return response()->json([
                    'status' => false,
                    'dados' => [
                        'mensagem' => 'Tipo de produto não encontrado.',
                    ],
                ], Response::HTTP_NOT_FOUND);
            }

            $tipoProduto->update([
                'nome' => $request->nome,
            ]);

            return response()->json([
                'status' => true,
                'dados' => [
                    'mensagem' => 'Tipo de produto atualizado com sucesso!',
                    'tipo_produto' => $tipoProduto,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'dados' => [
                    'mensagem' => 'Erro ao atualizar o tipo de produto',
                    'erro' => $e->getMessage(),
                ],
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
