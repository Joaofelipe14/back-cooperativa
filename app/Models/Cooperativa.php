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
        'cep',
        'endereco'
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
