<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Localizacao extends Model
{
    use HasFactory;

    protected $table = 'localizacao';

    protected $fillable = [
        'descricao',
        'descricao_amigavel',
        'latitude',
        'longitude'
    ];
}
