<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProdutoController extends Controller
{
    /**
     * Lista todos os produtos (apenas Admin) com paginação e ordenação por cadastro.
     */
    public function index(Request $request)
    {
        try {
            $userAuth = Auth::user();

            if ($userAuth->tipo_usuario !== 'admin') {
                return response()->json(['erro' => 'Acesso não autorizado'], 403);
            }
            $nome = $request->input('searchTerm', ''); 

            $produtos = Produto::with(['tipo', 'status', 'localizacao', 'user'])
                ->when($nome, function ($query, $nome) {
                    return $query->where('nome', 'like', "%{$nome}%"); 
                })
                ->orderBy('created_at', 'desc')
                ->paginate($request->input('per_page', 10));

            return response()->json($produtos);
        } catch (\Throwable $e) {
            return response()->json(['erro' => 'Erro ao listar produtos', 'detalhes' => $e->getMessage()], 500);
        }
    }


    /**
     * Lista produtos do usuário logado com paginação.
     */
    public function meusProdutos(Request $request)
    {
        try {
            $userAuth = Auth::user();

            $produtos = Produto::with(['tipo', 'status', 'localizacao'])
                ->where('user_id', $userAuth->id)
                ->orderBy('created_at', 'desc')
                ->paginate($request->input('per_page', 10));

            return response()->json($produtos);
        } catch (\Throwable $e) {
            return response()->json(['erro' => 'Erro ao listar seus produtos', 'detalhes' => $e->getMessage()], 500);
        }
    }

    /**
     * Cadastra um novo produto.
     */
    public function store(Request $request)
    {
        try {
            $userAuth = Auth::user();

            $data = $request->validate([
                'tipo_id' => 'required|exists:tipos_produtos,id',
                'status_id' => 'required|exists:status_produtos,id',
                'localizacao_id' => 'required|exists:localizacao,id',
                'nome' => 'required|string|max:255',
                'descricao' => 'nullable|string',
                'preco' => 'required|numeric|min:0',
                'quantidade' => 'required|integer|min:1',
                'unidade_medida' => 'required|string|max:50',
                'imagem' => 'nullable|string',
            ]);

            $data['user_id'] = $userAuth->id;

            $produto = Produto::create($data);

            return response()->json($produto, 201);
        } catch (\Throwable $e) {
            return response()->json(['erro' => 'Erro ao cadastrar produto', 'detalhes' => $e->getMessage()], 500);
        }
    }

    /**
     * Mostra detalhes de um produto.
     */
    public function show($id)
    {
        try {
            $produto = Produto::with(['tipo', 'status', 'localizacao', 'user'])->findOrFail($id);
            return response()->json($produto);
        } catch (\Throwable $e) {
            return response()->json(['erro' => 'Produto não encontrado', 'detalhes' => $e->getMessage()], 404);
        }
    }

    /**
     * Atualiza produto do usuário logado.
     */
    public function update(Request $request, $id)
    {
        try {
            $userAuth = Auth::user();
            $produto = Produto::findOrFail($id);

            if ($produto->user_id !== $userAuth->id) {
                return response()->json(['erro' => 'Acesso não autorizado'], 403);
            }

            $data = $request->validate([
                'tipo_id' => 'sometimes|exists:tipos_produtos,id',
                'status_id' => 'sometimes|exists:status_produtos,id',
                'localizacao_id' => 'sometimes|exists:localizacao,id',
                'nome' => 'sometimes|string|max:255',
                'descricao' => 'nullable|string',
                'preco' => 'sometimes|numeric|min:0',
                'quantidade' => 'sometimes|integer|min:1',
                'unidade_medida' => 'sometimes|string|max:50',
                'imagem' => 'sometimes|string',
            ]);

            $produto->update($data);

            return response()->json($produto);
        } catch (\Throwable $e) {
            return response()->json(['erro' => 'Erro ao atualizar produto', 'detalhes' => $e->getMessage()], 500);
        }
    }

    /**
     * Deleta produto do usuário logado.
     */
    public function destroy($id)
    {
        try {
            $userAuth = Auth::user();
            $produto = Produto::findOrFail($id);

            if ($produto->user_id !== $userAuth->id) {
                return response()->json(['erro' => 'Acesso não autorizado'], 403);
            }

            $produto->delete();

            return response()->json(['mensagem' => 'Produto removido com sucesso']);
        } catch (\Throwable $e) {
            return response()->json(['erro' => 'Erro ao deletar produto', 'detalhes' => $e->getMessage()], 500);
        }
    }
}
