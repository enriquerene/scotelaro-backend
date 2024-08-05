<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Usuario extends Authenticable
{
    use HasFactory;

    protected $table = 'usuarios';
    protected $appends = ['token'];
    protected string $authToken;
    protected $fillable = [
        'nome',
        'uuid',
        'whatsapp',
        'senha',
        'email',
        'data_validade_plano'
    ];
    protected $hidden = [
        'id',
        'senha',
    ];

    public function defineToken(string $token): void
    {
        $this->authToken = $token;
    }

    public function getTokenAttribute(): string
    {
        if (empty($this->authToken)) {
            return '';
        }
        return $this->authToken;
    }

    public function setSenhaAttribute(string $senha): void
    {
        $this->attributes['senha'] = bcrypt($senha);
    }

    public function plano(): BelongsTo
    {
        return $this->belongsTo(Plano::class);
    }
}
