<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Core\Application\Identity\UseCases\LoginUser;
use Core\Application\Identity\UseCases\RegisterUser;
use Core\Application\Identity\Ports\AuthenticationServiceInterface;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use RESTfulTemplate\ResponseTemplate;

class AuthController extends Controller
{
    private LoginUser $loginUser;
    private RegisterUser $registerUser;
    private AuthenticationServiceInterface $authService;

    public function __construct(
        LoginUser $loginUser,
        RegisterUser $registerUser,
        AuthenticationServiceInterface $authService
    ) {
        $this->loginUser = $loginUser;
        $this->registerUser = $registerUser;
        $this->authService = $authService;
    }

    /**
     * @throws Exception
     */
    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'whatsapp' => 'required|digits:11',
            'senha' => 'required|min:8',
        ]);

        try {
            $result = $this->loginUser->execute($request->whatsapp, $request->senha);
            $user = $result['user'];
            $token = $result['token'];

            $userData = $user->toArray();
            $userData['token'] = $token;

            $rest = new ResponseTemplate(200);
            $response = $rest->build($userData);
            return response()->json($response, $rest->getStatus()['code']);
        } catch (Exception $e) {
            $rest = new ResponseTemplate($e->getCode() ?: 401);
            $response = $rest->build(['message' => $e->getMessage()]);
            return response()->json($response, $rest->getStatus()['code']);
        }
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

        try {
            $user = $this->registerUser->execute($request->all());
            $rest = new ResponseTemplate(200);
            $response = $rest->build($user->toArray());
            return response()->json($response, $rest->getStatus()['code']);
        } catch (Exception $e) {
            $rest = new ResponseTemplate($e->getCode() ?: 400);
            $response = $rest->build(['message' => $e->getMessage()]);
            return response()->json($response, $rest->getStatus()['code']);
        }
    }

    /**
     * @throws Exception
     */
    public function logout(Request $request): JsonResponse
    {
        $request->validate([
            'uuid' => 'required|string'
        ]);

        $this->authService->logout($request->uuid);

        $rest = new ResponseTemplate(200);
        $response = $rest->build(['message' => 'Logout bem sucedido']);
        return response()->json($response, $rest->getStatus()['code']);
    }
}
