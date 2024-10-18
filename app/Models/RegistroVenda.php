<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistroVenda extends Model
{
    use HasFactory;

    protected $table = 'registro_venda';

    protected $fillable = [
        'ponto_venda',
        'quantidade',
        'valor',
        'id_user_venda',
        'pescado'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user_venda');
    }
}
