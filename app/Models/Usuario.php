<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

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
        'data_inscricao_plano'
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

    public function historicoPlanos(): HasMany
    {
        return $this->hasMany(HistoricoPlanos::class);
    }
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->uuid) {
                $model->uuid = Str::uuid()->toString();
            }
        });
    }
}
