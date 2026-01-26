<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use FightGym\Application\Training\UseCases\ListTrainingTypes;
use FightGym\Application\Training\UseCases\CreateTrainingType;
use FightGym\Application\Training\Ports\TrainingTypeRepositoryInterface;
use App\Models\Modalidade;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use RESTfulTemplate\ResponseTemplate;

class ModalidadesController extends Controller
{
    private ListTrainingTypes $listTrainingTypes;
    private CreateTrainingType $createTrainingType;
    private TrainingTypeRepositoryInterface $repository;

    public function __construct(
        ListTrainingTypes $listTrainingTypes,
        CreateTrainingType $createTrainingType,
        TrainingTypeRepositoryInterface $repository
    ) {
        $this->listTrainingTypes = $listTrainingTypes;
        $this->createTrainingType = $createTrainingType;
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     */
    public function listar(): JsonResponse
    {
        $modalidades = $this->listTrainingTypes->execute();
        if (empty($modalidades)) {
            $rest = new ResponseTemplate(404);
            $response = $rest->build(['message' => 'Nenhuma Modalidade cadastrada.']);
            return response()->json($response, $rest->getStatus()['code']);
        }
        $rest = new ResponseTemplate(200);
        $response = $rest->build($modalidades);
        return response()->json($response, $rest->getStatus()['code']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function criar(Request $request): JsonResponse
    {
        $dados = $request->all();
        $regras = [
            'nome' => 'required|string',
            'descricao' => 'required|string',
        ];
        $validador = Validator::make($dados, $regras);
        if ($validador->fails()) {
            $rest = new ResponseTemplate(400);
            $response = $rest->build(['message' => $validador->errors()]);
            return Response::json($response, $rest->getStatus()['code']);
        }

        $modalidade = $this->createTrainingType->execute($dados);

        $rest = new ResponseTemplate(201);
        $response = $rest->build(['modalidade' => $modalidade->toArray()]);
        return response()->json($response, $rest->getStatus()['code']);
    }

    public function defineImagem(Request $request, $id): JsonResponse
    {
        $request->validate([
            'imagem' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('imagem')) {
            $imagem = $request->file('imagem');
            $path = $imagem->store('modalidades', 'public');
            $trainingType = $this->repository->findById((int)$id);
            if ($trainingType) {
                $updatedTrainingType = new TrainingType(
                    $trainingType->getName(),
                    $trainingType->getDescription(),
                    $path,
                    $trainingType->getId()
                );
                $this->repository->save($updatedTrainingType);

                $rest = new ResponseTemplate(200);
                $response = $rest->build(['modalidade' => $updatedTrainingType->toArray()]);
                return response()->json($response, $rest->getStatus()['code']);
            }

            $rest = new ResponseTemplate(404);
            $response = $rest->build(['message' => 'Modalidade não encontrada.']);
            return response()->json($response, $rest->getStatus()['code']);
        }

        $rest = new ResponseTemplate(400);
        $response = $rest->build(['message' => 'Arquivo de imagem não enviado.']);
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
     * @throws \Exception
     */
    public function atualizar(Request $request, string $id): JsonResponse
    {
        $dados = $request->all();
        $regras = [
            'nome' => 'string',
            'descricao' => 'string',
        ];
        $validador = Validator::make($dados, $regras);
        if ($validador->fails()) {
            $rest = new ResponseTemplate(400);
            $response = $rest->build(['message' => $validador->errors()]);
            return Response::json($response, $rest->getStatus()['code']);
        }

        $trainingType = $this->repository->findById((int)$id);
        if ($trainingType) {
            $updatedTrainingType = new TrainingType(
                $dados['nome'] ?? $trainingType->getName(),
                $dados['descricao'] ?? $trainingType->getDescription(),
                $trainingType->getFeaturedImage(),
                $trainingType->getId()
            );
            $this->repository->save($updatedTrainingType);

            $rest = new ResponseTemplate(200);
            $response = $rest->build(['modalidade' => $updatedTrainingType->toArray()]);
            return response()->json($response, $rest->getStatus()['code']);
        }

        $rest = new ResponseTemplate(404);
        $response = $rest->build(['message' => 'Modalidade não encontrada.']);
        return response()->json($response, $rest->getStatus()['code']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
