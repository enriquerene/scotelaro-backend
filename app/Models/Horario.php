<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Horario extends Model
{
    use HasFactory;

    protected $table = 'horarios';
    protected $fillable = [
        'dia_semana',
        'hora_inicio',
        'hora_fim',
    ];

    public function turmas(): BelongsToMany
    {
        return $this->belongsToMany(Turma::class, 'turma_horarios', 'horario_id', 'turma_id');
    }
}
