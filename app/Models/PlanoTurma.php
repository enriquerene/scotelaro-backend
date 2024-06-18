<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlanoTurma extends Model
{
    use HasFactory;
    protected $table = 'plano_turmas';
    public function turma(): BelongsTo
    {
        return $this->belongsTo(Turma::class);
    }

    public function plano(): BelongsTo
    {
        return $this->belongsTo(Plano::class);
    }
}
