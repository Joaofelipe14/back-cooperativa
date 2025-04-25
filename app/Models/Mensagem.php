<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mensagem extends Model
{
    use SoftDeletes;

    protected $table = 'mensagens';


    protected $fillable = [
        'remetente_id',
        'destinatario_id',
        'conteudo',
        'lida',
        'resposta_id',
    ];

    public function remetente()
    {
        return $this->belongsTo(User::class, 'remetente_id');
    }

    public function destinatario()
    {
        return $this->belongsTo(User::class, 'destinatario_id');
    }

    public function resposta()
    {
        return $this->belongsTo(Mensagem::class, 'resposta_id');
    }
}
