<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plano extends Model
{
    use HasFactory;

    protected $table = 'planos';
    protected $fillable = [
        'nome',
        'valor',
        'descricao'
    ];

    public function usuarios(): HasMany
    {
        return $this->hasMany(Usuario::class);
    }

    public function planoTurmas(): HasMany
    {
        return $this->hasMany(PlanoTurma::class);
    }

}
