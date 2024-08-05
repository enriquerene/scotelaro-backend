<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Modalidade;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use RESTfulTemplate\ResponseTemplate;

class ModalidadesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function listar(): JsonResponse
    {
        $modalidades = Modalidade::all();
        if ($modalidades->isEmpty()) {
            $rest = new ResponseTemplate(404);
            $response = $rest->build(['message' => 'Nenhuma Modalidade cadastrada.']);
            return response()->json($response, $rest->getStatus()['code']);
        }
        $rest = new ResponseTemplate(200);
        $response = $rest->build($modalidades->toArray());
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

        $modalidade = new Modalidade();
        $modalidade->nome = $dados['nome'];
        $modalidade->descricao = $dados['descricao'];

        if ($modalidade->save()) {
            $rest = new ResponseTemplate(201);
            $response = $rest->build(['modalidade' => $modalidade]);
            return response()->json($response, $rest->getStatus()['code']);
        }
        $rest = new ResponseTemplate(500);
        $response = $rest->build(['message' => 'Falha ao cadastrar.']);
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
            $modalidade = Modalidade::find($id);
            $modalidade->imagem_destacada = $path;
            if ($modalidade->save()) {
                $rest = new ResponseTemplate(200);
                $response = $rest->build(['modalidade' => $modalidade]);
                return response()->json($response, $rest->getStatus()['code']);
            }

            $rest = new ResponseTemplate(500);
            $response = $rest->build(['message' => 'Falha ao anexar imagem na modalidade.']);
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

        $modalidade = Modalidade::where('id', $id)->first();
        $modalidade->nome = $dados['nome'] ?? $modalidade->nome;
        $modalidade->descricao = $dados['descricao'] ?? $modalidade->descricao;

        if ($modalidade->save()) {
            $rest = new ResponseTemplate(200);
            $response = $rest->build(['modalidade' => $modalidade]);
            return response()->json($response, $rest->getStatus()['code']);
        }
        $rest = new ResponseTemplate(500);
        $response = $rest->build(['message' => 'Falha ao atualizar.']);
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
