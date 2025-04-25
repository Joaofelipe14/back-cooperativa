<?php

namespace App\Http\Controllers;

use App\Models\Mensagem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ChatController extends Controller
{
    public function listarConversas()
    {
        $usuarioId = Auth::id();
    
        $mensagens = Mensagem::where(function ($q) use ($usuarioId) {
                $q->where('remetente_id', $usuarioId)
                  ->orWhere('destinatario_id', $usuarioId);
            })
            ->with(['remetente', 'destinatario'])
            ->orderBy('created_at', 'desc') 
            ->get()
            ->groupBy(function ($item) use ($usuarioId) {
                return $item->remetente_id === $usuarioId ? $item->destinatario_id : $item->remetente_id;
            })
            ->map(function ($mensagens, $interlocutorId) use ($usuarioId) {
                $ultimaMensagem = $mensagens->first();
    
                $temNova = $mensagens->where('remetente_id', $interlocutorId)
                                     ->where('destinatario_id', $usuarioId)
                                     ->where('lida', false)
                                     ->isNotEmpty();
    
                $interlocutor = $ultimaMensagem->remetente_id == $usuarioId
                    ? $ultimaMensagem->destinatario
                    : $ultimaMensagem->remetente;
    
                return [
                    'usuario_id' => $interlocutor->id,
                    'nome' => $interlocutor->name ?? '', 
                    'ultima_mensagem' => [
                        'id' => $ultimaMensagem->id,
                        'texto' => $ultimaMensagem->conteudo,
                        'data' => $ultimaMensagem->created_at,
                        'lida' => $ultimaMensagem->lida,
                    ],
                    'tem_nova_mensagem' => $temNova,
                ];
            })
            ->values();
    
        return response()->json($mensagens);
    }
    

    public function listarUsuariosDisponiveis()
    {
        $usuarios = User::where('tipo_usuario', 'colaborador')
                        ->where('id', '!=', Auth::id())
                        ->get();

        return response()->json($usuarios);
    }

    public function listarMensagens($usuarioId)
    {
        $autenticadoId = Auth::id();

        Mensagem::where('remetente_id', $usuarioId)
            ->where('destinatario_id', $autenticadoId)
            ->where('lida', false)
            ->update(['lida' => true]);

        $mensagens = Mensagem::where(function($q) use ($autenticadoId, $usuarioId) {
            $q->where('remetente_id', $autenticadoId)->where('destinatario_id', $usuarioId);
        })->orWhere(function($q) use ($autenticadoId, $usuarioId) {
            $q->where('remetente_id', $usuarioId)->where('destinatario_id', $autenticadoId);
        })
        ->with('resposta')
        ->whereNull('deleted_at')
        ->orderBy('created_at', 'asc')
        ->get();

        return response()->json($mensagens);
    }

    public function enviarMensagem(Request $request)
    {
        $request->validate([
            'destinatario_id' => 'required|exists:users,id',
            'conteudo' => 'required|string',
            'resposta_id' => 'nullable|exists:mensagens,id'
        ]);

        if ($request->destinatario_id == Auth::id()) {
            return response()->json(['erro' => 'Não é permitido enviar mensagens para si mesmo.'], 403);
        }

        $mensagem = Mensagem::create([
            'remetente_id' => Auth::id(),
            'destinatario_id' => $request->destinatario_id,
            'conteudo' => $request->conteudo,
            'resposta_id' => $request->resposta_id,
        ]);

        return response()->json($mensagem, 201);
    }

    public function apagarMensagem($id)
    {
        $mensagem = Mensagem::findOrFail($id);

        if ($mensagem->remetente_id !== Auth::id()) {
            return response()->json(['erro' => 'Ação não autorizada.'], 403);
        }

        $mensagem->delete();

        return response()->json(['mensagem' => 'Mensagem apagada com sucesso.']);
    }

    public function contarNovasMensagens()
    {
        $usuarioId = Auth::id();

        $total = Mensagem::where('destinatario_id', $usuarioId)
                         ->where('lida', false)
                         ->count();

        return response()->json(['novas_mensagens' => $total]);
    }
}