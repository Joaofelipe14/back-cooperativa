<?php

namespace App\Http\Controllers;

use App\Models\Auditoria;
use App\Models\RegistroFinanceiro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\PDF as DomPDFPDF;
use Barryvdh\DomPDF\Facade\Pdf;


class RegistroFinanceiroController extends Controller
{
    public function index()
    {
        $registros = RegistroFinanceiro::all();
        return response()->json([
            'mensagem' => 'Registros listados com sucesso',
            'sucesso'=>true,
            'registros' => $registros,
        ]);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'data_inicial' => 'required|date',
                'data_final' => 'required|date|after_or_equal:data_inicial',
                'transporte' => 'required|string',
                'combustivel' => 'required|numeric',
                'embarcacao' => 'required|string',
                'energia' => 'required|numeric',
                'material' => 'required|string',
            ]);

            $registro = RegistroFinanceiro::create([
                'data_inicial' => $request->data_inicial,
                'data_final' => $request->data_final,
                'transporte' => $request->transporte,
                'combustivel' => $request->combustivel,
                'embarcacao' => $request->embarcacao,
                'energia' => $request->energia,
                'user_id' => Auth::id(),
                'material' => $request->material,
            ]);



            $user = Auth::user();
            $dados = [
                'user_id'   => $user->id,            
                'acao'      => 'create',  
                'tabela'    => 'registros_financeiros',  
                'historico' =>   $registro
            ];
            
            Auditoria::create($dados);

            return response()->json([
                'mensagem' => 'Registro financeiro criado com sucesso',
                'registro' => $registro,
                'sucesso'=>true
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'mensagem' => 'Erro ao criar registro financeiro',
                'sucesso'=>false,
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
                'data_inicial' => 'required|date',
                'data_final' => 'required|date|after_or_equal:data_inicial',
                'transporte' => 'required|numeric',
                'combustivel' => 'required|numeric',
                'embarcacao' => 'required|string',
                'energia' => 'required|numeric',
                'material' => 'required|string',
            ]);

            $registro->update([
                'data_inicial' => $request->data_inicial,
                'data_final' => $request->data_final,
                'transporte' => $request->transporte,
                'combustivel' => $request->combustivel,
                'embarcacao' => $request->embarcacao,
                'energia' => $request->energia,
                'material' => $request->material,
            ]);

            return response()->json([
                'mensagem' => 'Registro financeiro atualizado com sucesso',
                'registro' => $registro,
                'sucesso'=>true

            ]);
        } catch (\Exception $e) {
            return response()->json([
                'mensagem' => 'Erro ao atualizar registro financeiro',
                'erro' => $e->getMessage(),
                'sucesso'=>false

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
                'sucesso'=>true

            ]);
        } catch (\Exception $e) {
            return response()->json([
                'mensagem' => 'Erro ao deletar registro financeiro',
                'erro' => $e->getMessage(),
            ], 500);
        }
    }


    public function gerarPdf(Request $request)
    {
        $ids = $request->input('ids');
        //$ids = (1, 500); 

        $registros = RegistroFinanceiro::whereIn('id', $ids)->get();

        if ($registros->isEmpty()) {
            return response()->json([
                'mensagem' => 'Nenhum registro encontrado.',
                'sucesso' => false,
            ], 404);
        }

        $user = Auth::user(); 
        $pdf = PDF::loadView('pdf.financeiro', compact('registros', 'user'));

       return $pdf->download('registros_financeiros.pdf');
    }
}
