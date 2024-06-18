<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class AuthToken extends Model
{
    use HasFactory;
    protected $table = 'auth_tokens';
    protected $fillable = [
        'token',
        'usuario_uuid',
        'expira_em',
    ];
    protected function gerarToken(): string
    {
        return Str::random(64);
    }
    protected function gerarTokenUnico(): string
    {
        do {
            $token = $this->gerarToken();
        } while ($this->where('token', $token)->exists());
        return $token;
    }

    public function autenticarUsuario(string $usuario_uuid): void
    {
        $this->usuario_uuid = $usuario_uuid;
        $this->token = $this->gerarTokenUnico();
        $this->expira_em = now()->addHours(24);
        $this->save();
    }

    public function limparAutenticacao(): void
    {
        $this->token = null;
        $this->expira_em = null;
        $this->update();
    }
}
