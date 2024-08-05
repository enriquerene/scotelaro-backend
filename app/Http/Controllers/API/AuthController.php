<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\AuthToken as Token;
use App\Models\Usuario;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use RESTfulTemplate\ResponseTemplate;

class AuthController extends Controller
{
    /**
     * @throws Exception
     */
    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'whatsapp' => 'required|digits:11',
            'senha' => 'required|min:8',
        ]);
        $data = $request->all();
        $user = Usuario::with('plano')->where('whatsapp', $data['whatsapp'])->first();
        if (!$user || !Hash::check($data['senha'], $user->senha)) {
            $rest = new ResponseTemplate(401);
            $response = $rest->build(['message' => 'Credenciais inválidas']);
            return response()->json($response, $rest->getStatus()['code']);
        }
        $token = Token::where('usuario_uuid', $user->uuid)->first();
        if (!$token) {
            $token = new Token();
        }
        $token->autenticarUsuario($user->uuid);
        $user->defineToken($token->token);
        $rest = new ResponseTemplate(200);
        $response = $rest->build($user->toArray());
        return response()->json($response, $rest->getStatus()['code']);
    }

    /**
     * @throws Exception
     */
    public function registrar(Request $request): JsonResponse
    {
        $request->validate([
            'nome' => 'required|min:3',
            'whatsapp' => 'required|digits:11',
            'senha' => 'required|min:8',
        ]);
        $data = $request->all();
        $user = Usuario::where('whatsapp', $data['whatsapp'])->first();
        if ($user) {
            $rest = new ResponseTemplate(400);
            $response = $rest->build(['message' => 'Usuário já registrado']);
            return response()->json($response, $rest->getStatus()['code']);
        }
        $user = new Usuario();
        $user->nome = $data['nome'];
        $user->senha = $data['senha'];
        $user->whatsapp = $data['whatsapp'];
        $user->save();
        $rest = new ResponseTemplate(200);
        $response = $rest->build($user->toArray());
        return response()->json($response, $rest->getStatus()['code']);
    }

    /**
     * @throws Exception
     */
    public function logout(Request $request): JsonResponse
    {
        $request->validate([
            'uuid' => 'required|string'
        ]);
        $uuid = $request->uuid;
        $user = Usuario::where('uuid', $uuid)->first();
        if (!$user) {
            $rest = new ResponseTemplate(404);
            $response = $rest->build(['message' => 'Usuário não encontrado']);
            return response()->json($response, $rest->getStatus()['code']);
        }
        $token = Token::where('usuario_uuid', $uuid)->first();
        if (!$token) {
            $rest = new ResponseTemplate(401);
            $response = $rest->build(['message' => 'Token inválido']);
            return response()->json($response, $rest->getStatus()['code']);
        }
        $token->limparAutenticacao();
        $rest = new ResponseTemplate(200);
        $response = $rest->build(['message' => 'Logout bem sucedido']);
        return response()->json($response, $rest->getStatus()['code']);
    }
}
