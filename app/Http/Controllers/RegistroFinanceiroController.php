<?php

namespace App\Http\Controllers;

use App\Models\RegistroFinanceiro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegistroFinanceiroController extends Controller
{
    public function index()
    {
        $registros = RegistroFinanceiro::all();
        return response()->json([
            'mensagem' => 'Registros listados com sucesso',
            'registros' => $registros,
        ]);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'periodicidade' => 'required|string',
                'transporte' => 'required|numeric',
                'combustivel' => 'required|numeric',
                'embarcacao' => 'required|string',
                'energia' => 'required|numeric',
                'material' => 'required|string',
            ]);

            $registro = RegistroFinanceiro::create([
                'periodicidade' => $request->periodicidade,
                'transporte' => $request->transporte,
                'combustivel' => $request->combustivel,
                'embarcacao' => $request->embarcacao,
                'energia' => $request->energia,
                'user_id' => Auth::id(),
                'material' => $request->material,
            ]);

            return response()->json([
                'mensagem' => 'Registro financeiro criado com sucesso',
                'registro' => $registro,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'mensagem' => 'Erro ao criar registro financeiro',
                'erro' => $e->getMessage(),
            ], 500);
        }
    }

    public function show($id)
    {
        $registro = RegistroFinanceiro::find($id);

        if (!$registro) {
            return response()->json([
                'mensagem' => 'Registro financeiro não encontrado',
            ], 404);
        }

        return response()->json([
            'mensagem' => 'Registro financeiro encontrado com sucesso',
            'registro' => $registro,
        ]);
    }

    public function update(Request $request, $id)
    {
        try {
            $registro = RegistroFinanceiro::find($id);

            if (!$registro) {
                return response()->json([
                    'mensagem' => 'Registro financeiro não encontrado',
                ], 404);
            }

            $request->validate([
                'periodicidade' => 'required|string',
                'transporte' => 'required|numeric',
                'combustivel' => 'required|numeric',
                'embarcacao' => 'required|string',
                'energia' => 'required|numeric',
                'material' => 'required|string',
            ]);

            $registro->update([
                'periodicidade' => $request->periodicidade,
                'transporte' => $request->transporte,
                'combustivel' => $request->combustivel,
                'embarcacao' => $request->embarcacao,
                'energia' => $request->energia,
                'material' => $request->material,
            ]);

            return response()->json([
                'mensagem' => 'Registro financeiro atualizado com sucesso',
                'registro' => $registro,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'mensagem' => 'Erro ao atualizar registro financeiro',
                'erro' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $registro = RegistroFinanceiro::find($id);

            if (!$registro) {
                return response()->json([
                    'mensagem' => 'Registro financeiro não encontrado',
                ], 404);
            }

            $registro->delete();

            return response()->json([
                'mensagem' => 'Registro financeiro deletado com sucesso',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'mensagem' => 'Erro ao deletar registro financeiro',
                'erro' => $e->getMessage(),
            ], 500);
        }
    }
}
