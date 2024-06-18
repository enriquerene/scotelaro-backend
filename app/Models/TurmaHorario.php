<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TurmaHorario extends Model
{
    use HasFactory;
    protected $table = 'turma_horarios';
    public function horario(): BelongsTo
    {
        return $this->belongsTo(Horario::class);
    }

    public function turma(): BelongsTo
    {
        return $this->belongsTo(Turma::class);
    }
}
