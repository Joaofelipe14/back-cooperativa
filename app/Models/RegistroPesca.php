<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistroPesca extends Model
{
    use HasFactory;

    protected $table = 'registro_pesca';

    protected $fillable = [
        'local',
        'data_com_hora',
        'codigo',
        'id_user',
        'pescado',
        'quantidade'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
