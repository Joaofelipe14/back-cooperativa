<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistroFinanceiro extends Model
{
    use HasFactory;

    protected $fillable = [
        'periodicidade',
        'transporte',
        'combustivel',
        'embarcacao',
        'energia',
        'user_id',
        'material',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
