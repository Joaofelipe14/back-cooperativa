<?php

namespace App\Http\Controllers;

use App\Models\Cooperativa;
use App\Models\RegistroPesca;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class RegistroPescaController extends Controller
{
    public function store(Request $request)
    {
        try {
            $request->validate([
                'local' => 'required|integer',
                'data_com_hora' => 'date',
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

            if ($userAuth->id !== $registro->id_user) {
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
                    'user' =>            $user
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

    public function getAll(Request $request)
    {
        try {
            $page = $request->input('page', 1);
            $limit = $request->input('limit', 5);
            $searchTerm = $request->input('searchTerm', '');
            $selectedLocalizacao = $request->input('selectedLocalizacao', null);

            $query = RegistroPesca::with(['user', 'localizacao']);

            if ($searchTerm) {
                $query->whereHas('user', function ($q) use ($searchTerm) {
                    $q->where('name', 'like', '%' . $searchTerm . '%');
                });
            }

            if ($selectedLocalizacao) {
                $query->where('local', $selectedLocalizacao);
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
                    'mensagem' => 'Erro ao obter todos os registros de pesca',
                    'erro' => $e->getMessage(),
                ],
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function gerarRelatorio(Request $request)
    {
        DB::enableQueryLog();

        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
        $location = $request->input('location');
        $userIds = $request->input('userIds');
        $registros = RegistroPesca::with(['user', 'localizacao']);

        if (!empty($startDate) && !empty($endDate)) {
            $registros->whereBetween('created_at', [$startDate, $endDate]);
        }

        if (!empty($location) && $location !='todos') {
            $registros->where('local', "$location");
        }

        if (!empty($userIds) && is_array($userIds)) {
            $registros->whereIn('id_user', $userIds);
        }

        $registros = $registros->get();
     
        // $queries = DB::getQueryLog();
        // $lastQuery = end($queries);
        // $sqlWithBindings = vsprintf(str_replace('?', "'%s'", $lastQuery['query']), $lastQuery['bindings']);
        // dd($sqlWithBindings); 
        
        if ($registros->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'Não há registros de pesca para os filtros informados.',
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

        $pdf = PDF::loadView('pdf.relatorio_pesca', compact('registros', 'user', 'cooperativa'));

        return $pdf->download('registro_pesca' . '.pdf');
    }
}
