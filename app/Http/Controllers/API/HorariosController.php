<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Core\Application\Training\UseCases\ListSchedules;
use App\Models\Horario;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use RESTfulTemplate\ResponseTemplate;
use Illuminate\Http\JsonResponse;

class HorariosController extends Controller
{
    private ListSchedules $listSchedules;

    public function __construct(ListSchedules $listSchedules)
    {
        $this->listSchedules = $listSchedules;
    }

    /**
     * Display a listing of the resource.
     * @throws Exception
     */
    public function listar(): JsonResponse
    {
        $horarios = $this->listSchedules->execute();
        if (empty($horarios)) {
            $rest = new ResponseTemplate(404);
            $response = $rest->build(['message' => 'Nenhuma Horario cadastrado.']);
            return response()->json($response, $rest->getStatus()['code']);
        }
        $rest = new ResponseTemplate(200);
        $response = $rest->build($horarios);
        return response()->json($response, $rest->getStatus()['code']);
    }

    /**
     * Store a newly created resource in storage.
     * @throws Exception
     */
    public function criar(Request $request): JsonResponse
    {
        $dados = $request->all();
        $regras = [
            'dia_semana' => 'required|numeric|between:0,6',
            'hora_inicio' => 'required|string',
            'hora_fim' => 'required|string',
        ];
        $validador = Validator::make($dados, $regras);
        if ($validador->fails()) {
            $rest = new ResponseTemplate(400);
            $response = $rest->build(['message' => $validador->errors()]);
            return Response::json($response, $rest->getStatus()['code']);
        }

        $horario = new Horario();
        $horario->hora_inicio = $dados['hora_inicio'];
        $horario->hora_fim = $dados['hora_fim'];
        $horario->dia_semana = (int) $dados['dia_semana'];

        if ($horario->save()) {
            $rest = new ResponseTemplate(201);
            $response = $rest->build(['horario' => $horario]);
            return response()->json($response, $rest->getStatus()['code']);
        }
        $rest = new ResponseTemplate(500);
        $response = $rest->build(['message' => 'Falha ao cadastrar.']);
        return response()->json($response, $rest->getStatus()['code']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
