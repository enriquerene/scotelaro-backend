<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Plano;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use RESTfulTemplate\ResponseTemplate;

class UsuariosController extends Controller
{
    /**
     * @throws Exception
     */
    public function inscricaoEmPlano(Request $request): JsonResponse
    {
        $planoId = (int) $request->input('id');
        if (!Plano::where('id', $planoId)->exists()) {
            $rest = new ResponseTemplate(404);
            $response = $rest->build(['message' => 'O plano requisitado não existe.']);
            return response()->json($response, $rest->getStatus()['code']);
        }

        $usuario = $request->get('usuario');
        $usuario->plano_id = $planoId;
        $usuario->data_inscricao_plano = Carbon::now()->toDateString();
        if (!$usuario->save()) {
            $rest = new ResponseTemplate(500);
            $response = $rest->build(['message' => 'Falha ao vincular plano requisitado ao usuário.']);
            return response()->json($response, $rest->getStatus()['code']);
        }

        $usuario->load('plano');
        $usuario->plano->load('turmas');
        $rest = new ResponseTemplate(200);
        $response = $rest->build($usuario->toArray());
        return response()->json($response, $rest->getStatus()['code']);
    }

    /**
     * @throws Exception
     */
    public function cancelarPlano(Request $request): JsonResponse
    {
        $usuario = $request->get('usuario');
        if (!$usuario->plano_id) {
            $rest = new ResponseTemplate(400);
            $response = $rest->build(['message' => 'Usuário não está inscrito em nenhum plano.']);
            return response()->json($response, $rest->getStatus()['code']);
        }
        // verificar pagamentos pendentes
        // if pagemento pendente deve resultar em falha
        $usuario->data_inscricao_plano = null;
        $usuario->plano_id = null;
        if (!$usuario->save()) {
            $rest = new ResponseTemplate(500);
            $response = $rest->build(['message' => 'Falha ao desvincular plano do usuário.']);
            return response()->json($response, $rest->getStatus()['code']);
        }

        $usuario->load('plano');
        $rest = new ResponseTemplate(200);
        $response = $rest->build($usuario->toArray());
        return response()->json($response, $rest->getStatus()['code']);
    }
}
