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
                'ponto_venda' => 'required|integer|max:255',
                'quantidade' => 'required|integer',
                'valor' => 'required|numeric',
            ]);

            $user = Auth::user();
            $data = $request->all();
            $data['id_user_venda'] = $user->id;

            do {
                $codigo = mt_rand(100000, 999999);
            } while (RegistroVenda::where('codigo', $codigo)->exists());
        
            $data['codigo'] = $codigo;

            $registro = RegistroVenda::create($data);

            $registro_novo = RegistroVenda::with('localizacao')->where('id', $registro->id)->get();


            return response()->json([
                'status' => true,
                'dados' => [
                    'mensagem' => 'Registro de venda criado com sucesso',
                    'registro' => $registro_novo,
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
               
                'id_user_venda' => 'required|exists:users,id',
            ]);

            $registro = RegistroVenda::findOrFail($id);

            $userAuth = Auth::user();

            if ($userAuth->id !== $registro->id_user_venda  ) {
                return response()->json([
                    'status' => false,
                    'dados' => ['mensagem' => 'Usuário não encontrado ou não autorizado.']
                ], 403);
            }

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
            $registros = RegistroVenda::with('localizacao')->where('id_user_venda', $user->id)->get();

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

