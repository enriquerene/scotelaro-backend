<?php

namespace App\Http\Middleware;

use App\Models\AuthToken;
use Carbon\Carbon;
use Closure;
use FightGym\Application\Identity\Ports\UserRepositoryInterface;
use Exception;
use Illuminate\Http\Request;
use RESTfulTemplate\ResponseTemplate;
use Symfony\Component\HttpFoundation\Response;

class UserTokenAuthentication
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {
    }

    /**
     * @param Closure(Request): (Response) $next
     * @throws Exception
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

        if ($authToken->expira_em && $authToken->expira_em < Carbon::now()) {
            $rest = new ResponseTemplate(400);
            $response = $rest->build(['message' => 'Token de autenticação expirado. Faça login novamente.']);
            return response()->json($response, $rest->getStatus()['code']);
        }

        $user = $this->userRepository->findByUuid($authToken->usuario_uuid);
        if (!$user) {
            $rest = new ResponseTemplate(400);
            $response = $rest->build(['message' => 'Nenhum usuário vinculado ao token de autenticação fornecido.']);
            return response()->json($response, $rest->getStatus()['code']);
        }

        $request->attributes->set('usuario', $user);
        return $next($request);
    }
}
