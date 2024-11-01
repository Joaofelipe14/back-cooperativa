<?php

namespace App\Http\Controllers;

use App\Models\RegistroPesca;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

class RegistroPescaController extends Controller
{
    public function store(Request $request)
    {
        try {
            $request->validate([
                'local' => 'required|integer',
                'data_com_hora' => 'required|date',
            ]);

            $user = Auth::user();
            $data = $request->all();
            $data['id_user'] = $user->id;

            do {
                $codigo = mt_rand(100000, 999999);
            } while (RegistroPesca::where('codigo', $codigo)->exists());
        
            $data['codigo'] = $codigo;

            $registro = RegistroPesca::create($data);

            $registro_novo = RegistroPesca::with('localizacao')->where('id', $registro->id)->get();


            return response()->json([
                'status' => true,
                'dados' => [
                    'mensagem' => 'Registro de pesca criado com sucesso',
                    'registro' => $registro_novo,
                ],
            ], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'dados' => [
                    'mensagem' => 'Erro ao criar registro de pesca',
                    'erro' => $e->getMessage(),
                ],
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
    
                'id_user' => 'required|exists:users,id',
            ]);

            $registro = RegistroPesca::findOrFail($id);

            $userAuth = Auth::user();

            if ($userAuth->id !== $registro->id_user  ) {
                return response()->json([
                    'status' => false,
                    'dados' => ['mensagem' => 'Usuário não encontrado ou não autorizado.']
                ], 403);
            }

            $registro->update($request->all());

            return response()->json([
                'status' => true,
                'dados' => [
                    'mensagem' => 'Registro de pesca atualizado com sucesso',
                    'registro' => $registro,
                ],
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'dados' => [
                    'mensagem' => 'Registro de pesca não encontrado',
                    'erro' => $e->getMessage(),
                ],
            ], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'dados' => [
                    'mensagem' => 'Erro ao atualizar registro de pesca',
                    'erro' => $e->getMessage(),
                ],
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getByUserId()
    {
        try {

            $user = Auth::user();
            $registros = RegistroPesca::with('localizacao')->where('id_user', $user->id)->get();

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
                    'mensagem' => 'Erro ao obter registros de pesca',
                    'erro' => $e->getMessage(),
                ],
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getAll()
    {
        try {
            $registros = RegistroPesca::with('user')->get();

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
                    'mensagem' => 'Erro ao obter todos os registros de pesca',
                    'erro' => $e->getMessage(),
                ],
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
