<?php

namespace App\Http\Controllers;

use App\Models\RegistroVenda;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;


class RegistroVendaController extends Controller
{
    public function store(Request $request)
    {
        try {
            $request->validate([
                'ponto_venda' => 'required|string|max:255',
                'quantidade' => 'required|integer',
                'valor' => 'required|numeric',
            ]);

            $user = Auth::user();
            $data = $request->all();
            $data['id_user_venda'] = $user->id;
            $registro = RegistroVenda::create($data);

            return response()->json([
                'status' => true,
                'dados' => [
                    'mensagem' => 'Registro de venda criado com sucesso',
                    'registro' => $registro,
                ],
            ], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'dados' => [
                    'mensagem' => 'Erro ao criar registro de venda',
                    'erro' => $e->getMessage(),
                ],
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'ponto_venda' => 'required|string|max:255',
                'quantidade' => 'required|integer',
                'valor' => 'required|numeric',
                'id_user_venda' => 'required|exists:users,id',
            ]);

            $registro = RegistroVenda::findOrFail($id);
            $registro->update($request->all());

            return response()->json([
                'status' => true,
                'dados' => [
                    'mensagem' => 'Registro de venda atualizado com sucesso',
                    'registro' => $registro,
                ],
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'dados' => [
                    'mensagem' => 'Registro de venda não encontrado',
                    'erro' => $e->getMessage(),
                ],
            ], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'dados' => [
                    'mensagem' => 'Erro ao atualizar registro de venda',
                    'erro' => $e->getMessage(),
                ],
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getByUserId()
    {
        try {
            $user = Auth::user();
            $registros = RegistroVenda::where('id_user_venda', $user->id)->get();

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
                    'mensagem' => 'Erro ao obter registros de venda',
                    'erro' => $e->getMessage(),
                ],
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getAll()
    {
        try {
            $registros = RegistroVenda::with('user')->get();

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
                    'mensagem' => 'Erro ao obter todos os registros de venda',
                    'erro' => $e->getMessage(),
                ],
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

