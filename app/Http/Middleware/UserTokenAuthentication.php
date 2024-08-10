<?php

namespace App\Http\Middleware;

use App\Models\AuthToken;
use App\Models\Usuario;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use RESTfulTemplate\ResponseTemplate;
use Symfony\Component\HttpFoundation\Response;

class UserTokenAuthentication
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     * @throws \Exception
     */
    public function handle(Request $request, Closure $next): Response
    {
        $authorizationHeader = $request->header('Authorization');
        if (!$authorizationHeader || !str_contains($authorizationHeader, 'Bearer ')) {
            $rest = new ResponseTemplate(400);
            $response = $rest->build(['message' => 'Requisição sem parâmetro de autenticação.']);
            return response()->json($response, $rest->getStatus()['code']);
        }
        $utoken = substr($authorizationHeader, 7);
        $authToken = AuthToken::where('token', $utoken)->first();
        if (!$authToken) {
            $rest = new ResponseTemplate(400);
            $response = $rest->build(['message' => 'Token de autenticação inválido ou inexistente.']);
            return response()->json($response, $rest->getStatus()['code']);
        }
        if ($authToken->expira_em < Carbon::now()) {
            $rest = new ResponseTemplate(400);
            $response = $rest->build(['message' => 'Token de autenticação expirado. Faça login novamente.']);
            return response()->json($response, $rest->getStatus()['code']);
        }
        $usuario = Usuario::where('uuid', $authToken->usuario_uuid)->first();
        if (!$usuario) {
            $rest = new ResponseTemplate(400);
            $response = $rest->build(['message' => 'Nenhum usuário vinculado ao token de autenticação fornecido.']);
            return response()->json($response, $rest->getStatus()['code']);
        }
        $request->attributes->set('usuario', $usuario);
        return $next($request);
    }
}
