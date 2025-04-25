<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cooperativa extends Model
{
    use HasFactory;

    protected $table = 'cooperativa';

    protected $fillable = [
        'nome',
        'cnpj',
        'endereco',
        'cidade',
        'estado',
        'cep',
        'telefone',
        'email',
        'data_fundacao',
        'descricao',
        'url_foto',
    ];
  
}
