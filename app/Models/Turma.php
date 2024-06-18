<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Turma extends Model
{
    use HasFactory;
    protected $table = 'turmas';
    protected $fillable = ['nome'];

    public function modalidade(): BelongsTo
    {
        return $this->belongsTo(Modalidade::class);
    }

    public function turmaHorarios(): HasMany
    {
        return $this->hasMany(TurmaHorario::class);
    }

    public function planoTurmas(): HasMany
    {
        return $this->hasMany(PlanoTurma::class);
    }

}
