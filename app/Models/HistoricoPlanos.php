<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoricoPlanos extends Model
{
    use HasFactory;

    protected $table = 'historico_planos';
    protected $casts = [
        'data_inscricao' => 'datetime',
        'data_cancelamento' => 'datetime',
    ];
}
