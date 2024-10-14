<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistroFinanceiro extends Model
{
    use HasFactory;

    protected $table = 'registros_financeiros';

    protected $fillable = [
        'transporte',
        'combustivel',
        'embarcacao',
        'energia',
        'user_id',
        'material',
        'data_inicial',
        'data_final'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
