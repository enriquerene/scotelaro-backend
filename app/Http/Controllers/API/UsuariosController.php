<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Core\Application\Finance\UseCases\SubscribeToPlan;
use Core\Application\Finance\UseCases\CancelPlan;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use RESTfulTemplate\ResponseTemplate;

class UsuariosController extends Controller
{
    private SubscribeToPlan $subscribeToPlan;
    private CancelPlan $cancelPlan;

    public function __construct(SubscribeToPlan $subscribeToPlan, CancelPlan $cancelPlan)
    {
        $this->subscribeToPlan = $subscribeToPlan;
        $this->cancelPlan = $cancelPlan;
    }

    /**
     * @throws Exception
     */
    public function inscricaoEmPlano(Request $request): JsonResponse
    {
        $planoId = (int) $request->input('id');
        $usuario = $request->get('usuario');

        try {
            $updatedUser = $this->subscribeToPlan->execute($usuario->uuid, $planoId);

            $rest = new ResponseTemplate(200);
            $response = $rest->build($updatedUser->toArray());
            return response()->json($response, $rest->getStatus()['code']);
        } catch (Exception $e) {
            $rest = new ResponseTemplate($e->getCode() ?: 500);
            $response = $rest->build(['message' => $e->getMessage()]);
            return response()->json($response, $rest->getStatus()['code']);
        }
    }

    /**
     * @throws Exception
     */
    public function cancelarPlano(Request $request): JsonResponse
    {
        $usuario = $request->get('usuario');

        try {
            $updatedUser = $this->cancelPlan->execute($usuario->uuid);

            $rest = new ResponseTemplate(200);
            $response = $rest->build($updatedUser->toArray());
            return response()->json($response, $rest->getStatus()['code']);
        } catch (Exception $e) {
            $rest = new ResponseTemplate($e->getCode() ?: 500);
            $response = $rest->build(['message' => $e->getMessage()]);
            return response()->json($response, $rest->getStatus()['code']);
        }
    }
}
