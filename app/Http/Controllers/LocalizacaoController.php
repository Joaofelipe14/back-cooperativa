<?php

namespace App\Http\Controllers;

use App\Models\Localizacao;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LocalizacaoController extends Controller
{
    public function index()
    {
        try {
            $registros = Localizacao::orderBy('id', 'desc')->get();

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

    public function store(Request $request)
    {
        try {
            $localizacao = Localizacao::create($request->validate([
                'descricao' => 'required|string',
                'descricao_amigavel' => 'required|string',
                'latitude' => 'required|numeric',
                'longitude' => 'required|numeric',
            ]));

            return response()->json([
                'status' => true,
                'dados' => [
                    'mensagem' => 'Localização criada com sucesso',
                    'registro' => $localizacao,
                ],
            ], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'dados' => [
                    'mensagem' => 'Erro ao criar a localização',
                    'erro' => $e->getMessage(),
                ],
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show($id)
    {
        try {
            $localizacao = Localizacao::findOrFail($id);

            return response()->json([
                'status' => true,
                'dados' => [
                    'registro' => $localizacao,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'dados' => [
                    'mensagem' => 'Erro ao obter a localização',
                    'erro' => $e->getMessage(),
                ],
            ], Response::HTTP_NOT_FOUND);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $localizacao = Localizacao::findOrFail($id);
            $localizacao->update($request->validate([
                'descricao' => 'sometimes|required|string',
                'descricao_amigavel' => 'sometimes|required|string',
                'latitude' => 'sometimes|required|numeric',
                'longitude' => 'sometimes|required|numeric',
            ]));

            return response()->json([
                'status' => true,
                'dados' => [
                    'mensagem' => 'Localização atualizada com sucesso',
                    'registro' => $localizacao,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'dados' => [
                    'mensagem' => 'Erro ao atualizar a localização',
                    'erro' => $e->getMessage(),
                ],
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy($id)
    {
        try {
            $localizacao = Localizacao::findOrFail($id);
            $localizacao->delete();

            return response()->json([
                'status' => true,
                'dados' => [
                    'mensagem' => 'Localização deletada com sucesso',
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'dados' => [
                    'mensagem' => 'Erro ao deletar a localização',
                    'erro' => $e->getMessage(),
                ],
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
