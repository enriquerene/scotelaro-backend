<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Modalidade extends Model
{
    use HasFactory;
    protected $table = 'modalidades';
    protected $fillable = [
        'nome',
        'descricao',
        'imagem_destacada'
    ];

    public function turmas(): HasMany
    {
        return $this->hasMany(Turma::class);
    }
}
