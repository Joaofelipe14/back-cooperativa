<?php

namespace App\Http\Controllers;

use App\Models\Cooperativa;
use App\Models\RegistroVenda;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use Barryvdh\DomPDF\Facade\Pdf;


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
                    'user'=>            $user ,

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

    public function getAll(Request $request)
    {
        try {
            $registros = RegistroVenda::with(['user', 'localizacao'])->get();

            $page = $request->input('page', 1); 
            $limit = $request->input('limit', 5); 
            $searchTerm = $request->input('searchTerm', ''); 
            $selectedLocalizacao = $request->input('selectedLocalizacao', null); 
    
            $query = RegistroVenda::with(['user', 'localizacao']);
    
            if ($searchTerm) {
                $query->whereHas('user', function ($q) use ($searchTerm) {
                    $q->where('name', 'like', '%' . $searchTerm . '%');
                });
            }
    
            if ($selectedLocalizacao) {
                $query->where('ponto_venda', $selectedLocalizacao);
            }
    
            // Paginação
            $query->orderBy('id', 'desc');
            $registros = $query->paginate($limit, ['*'], 'page', $page);

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


    public function gerarRelatorio(Request $request)
    {
        $ids = $request->input('ids');
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
        $location = $request->input('location');
    
        // Validação simples dos filtros
        if (empty($startDate) || empty($endDate)) {
            return response()->json([
                'status' => false,
                'message' => 'Por favor, forneça o intervalo de datas.',
            ], 400);
        }
    
        $registros = RegistroVenda::with(['user', 'localizacao'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->where('localizacao', 'like', "%$location%")
            ->get();
    
        if ($registros->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'Nenhum registro encontrado.',
            ], 404);
        }
    
        $cooperativa = Cooperativa::first();
    
        if (!$cooperativa) {
            return response()->json([
                'status' => false,
                'message' => 'Cooperativa não encontrada.',
            ], 404);
        }
    
        $user = Auth::user();
        $imagePath = 'https://demopesca.netlify.app/assets/logoPrincipal.png';
        $imageData = file_get_contents($imagePath);
        $base64Image = base64_encode($imageData);
        $cooperativa->logo = $base64Image;
    
        $pdf = PDF::loadView('pdf.relatorio_venda', compact('registros', 'user', 'cooperativa'));
    
        // Retorna o PDF como resposta, para ser baixado pelo frontend
        return $pdf->download('registro_venda_' . date('Y-m-d_H-i-s') . '.pdf');

    }
    
}

