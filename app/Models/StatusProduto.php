<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusProduto extends Model
{
    protected $table = 'status_produtos';

    protected $fillable = ['nome'];

    public function produtos()
    {
        return $this->hasMany(Produto::class, 'status_id');
    }
}