<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Cooperativa;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CooperativaController extends Controller
{
    /**
     * Retorna a cooperativa (única).
     */
    public function show()
    {
        try {
            $registro = Cooperativa::first();

            return response()->json([
                'status' => true,
                'dados' => [
                    'registro' => $registro,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'dados' => [
                    'mensagem' => 'Erro ao obter o registro da cooperativa',
                    'erro' => $e->getMessage(),
                ],
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Atualiza os dados da cooperativa.
     */
    public function update(Request $request)
    {
        try {
            $registro = Cooperativa::first();

            if (!$registro) {
                return response()->json([
                    'status' => false,
                    'dados' => [
                        'mensagem' => 'Nenhuma cooperativa encontrada para atualizar',
                    ],
                ], Response::HTTP_NOT_FOUND);
            }

            // Atualiza campos básicos enviados
            $registro->update($request->only([
                'nome',
                'cnpj',
                'endereco',
                'cidade',
                'estado',
                'cep',
                'telefone',
                'email',
                'data_fundacao',
                'descricao',
            ]));

            // Se tiver arquivo enviado no campo 'url_foto'
            if ($request->hasFile('url_foto')) {
                $file = $request->file('url_foto');
                $path = $file->store('cooperativas', 'public');
                $url = asset("storage/{$path}");
                $registro->update([
                    'url_foto' => $url,
                ]);
            }

            return response()->json([
                'status' => true,
                'dados' => [
                    'registro' => $registro,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'dados' => [
                    'mensagem' => 'Erro ao atualizar o registro da cooperativa',
                    'erro' => $e->getMessage(),
                ],
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
