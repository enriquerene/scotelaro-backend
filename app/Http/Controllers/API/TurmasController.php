<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use FightGym\Application\Training\UseCases\ListTrainingClasses;
use App\Models\Turma;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use RESTfulTemplate\ResponseTemplate;

class TurmasController extends Controller
{
    private ListTrainingClasses $listTrainingClasses;

    public function __construct(ListTrainingClasses $listTrainingClasses)
    {
        $this->listTrainingClasses = $listTrainingClasses;
    }

    /**
     * Display a listing of the resource.
     * @throws \Exception
     */
    public function listar(): JsonResponse
    {
        $turmas = $this->listTrainingClasses->execute();
        if (empty($turmas)) {
            $rest = new ResponseTemplate(404);
            $response = $rest->build(['message' => 'Nenhuma Turma cadastrada.']);
            return response()->json($response, $rest->getStatus()['code']);
        }
        $rest = new ResponseTemplate(200);
        $response = $rest->build($turmas);
        return response()->json($response, $rest->getStatus()['code']);
    }

    /**
     * Store a newly created resource in storage.
     * @throws \Exception
     */
    public function criar(Request $request): JsonResponse
    {
        $dados = $request->all();
        $regras = [
            'nome' => 'required|string',
            'modalidade_id' => 'required|numeric',
            'horario_ids' => 'required|string',
            'valor' => 'nullable|numeric'
        ];
        $validador = Validator::make($dados, $regras);
        if ($validador->fails()) {
            $rest = new ResponseTemplate(400);
            $response = $rest->build(['message' => $validador->errors()]);
            return Response::json($response, $rest->getStatus()['code']);
        }

        $turma = new Turma();
        $turma->nome = $dados['nome'];
        $turma->modalidade_id = (int) $dados['modalidade_id'];
        if (isset($dados['valor'])) {
            $turma->valor = (int) $dados['valor'];
        }
        if ($turma->save()) {
            $horariosIds = explode(',', $dados['horario_ids']);
            foreach ($horariosIds as $horarioId) {
                $turma->horarios()->attach((int)$horarioId);
            }
            $rest = new ResponseTemplate(201);
            $response = $rest->build($turma->toArray());
            return response()->json($response, $rest->getStatus()['code']);
        }

        $rest = new ResponseTemplate(500);
        $response = $rest->build(['message' => 'Erro ao cadastrar turma.']);
        return response()->json($response, $rest->getStatus()['code']);
    }

    /**
     * Display the specified resource.
     * @throws \Exception
     */
    public function show(string $id): JsonResponse
    {
        $turma = Turma::with(['horarios','modalidade'])->find($id);
        if (!$turma) {
            $rest = new ResponseTemplate(404);
            $response = $rest->build(['message' => 'Turma não cadastrada.']);
            return response()->json($response, $rest->getStatus()['code']);
        }
        $rest = new ResponseTemplate(200);
        $response = $rest->build($turma->toArray());
        return response()->json($response, $rest->getStatus()['code']);
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
