<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Auditoria extends Model
{
    use HasFactory;

    protected $table = 'auditoria';

    protected $fillable = [
        'user_id',
        'acao',
        'tabela',
        'historico'
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
