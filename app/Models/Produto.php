<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    protected $fillable = [
        'user_id',
        'tipo_id',
        'status_id',
        'localizacao_id',
        'nome',
        'descricao',
        'preco',
        'quantidade',
        'unidade_medida',
        'imagem',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tipo()
    {
        return $this->belongsTo(TipoProduto::class, 'tipo_id');
    }

    public function status()
    {
        return $this->belongsTo(StatusProduto::class, 'status_id');
    }

    public function localizacao()
    {
        return $this->belongsTo(Localizacao::class,'localizacao_id');
    }
}