<?php

namespace Core\Infrastructure\Services;

use App\Models\AuthToken;
use Core\Application\Identity\Ports\AuthenticationServiceInterface;
use Illuminate\Support\Facades\Hash;

class LaravelAuthenticationService implements AuthenticationServiceInterface
{
    public function authenticate(string $userUuid): string
    {
        $token = AuthToken::where('usuario_uuid', $userUuid)->first();
        if (!$token) {
            $token = new AuthToken();
        }
        $token->autenticarUsuario($userUuid);
        return $token->token;
    }

    public function logout(string $userUuid): void
    {
        $token = AuthToken::where('usuario_uuid', $userUuid)->first();
        if ($token) {
            $token->limparAutenticacao();
        }
    }

    public function checkPassword(string $password, string $hashedPassword): bool
    {
        return Hash::check($password, $hashedPassword);
    }
}
