<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Turma extends Model
{
    use HasFactory;
    protected $table = 'turmas';
    protected $fillable = ['nome', 'modalidade_id', 'valor'];

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

    public function horarios(): BelongsToMany
    {
        return $this->belongsToMany(Horario::class, 'turma_horarios', 'turma_id', 'horario_id');
    }

}
