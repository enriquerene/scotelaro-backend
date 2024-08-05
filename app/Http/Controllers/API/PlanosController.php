<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Plano;
use App\Models\Turma;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use RESTfulTemplate\ResponseTemplate;

class PlanosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function listar(): JsonResponse
    {
        $planos = Plano::with('turmas')->get();
        if ($planos->isEmpty()) {
            $rest = new ResponseTemplate(404);
            $response = $rest->build(['message' => 'Nenhum plano cadastrado.']);
            return response()->json($response, $rest->getStatus()['code']);
        }
        $rest = new ResponseTemplate(200);
        $response = $rest->build($planos->toArray());
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
            'nome' => 'required|string',
            'descricao' => 'nullable|string',
            'valor' => 'required|numeric',
            'id_turmas' => 'required|string',
        ];
        $validador = Validator::make($dados, $regras);
        if ($validador->fails()) {
            $rest = new ResponseTemplate(400);
            $response = $rest->build(['message' => $validador->errors()]);
            return Response::json($response, $rest->getStatus()['code']);
        }

        $idsTurmas = array_map(
            'intval',
            explode(
                ',',
                $request->get('id_turmas')
              )
        );
        $turmas = Turma::whereIn('id', $idsTurmas)->get();
        try {
            $plano = DB::transaction(function () use ($turmas, $request) {
                $plano = Plano::create([
                    'nome' => $request->get('nome'),
                    'descricao' => $request->get('descricao'),
                    'valor' => intval($request->get('valor')),
                ]);

                $plano->turmas()->attach($turmas);
                return $plano;
            });

//            $resultado = Turma::where('nome', $request->get('nome'))->first();
            $resultado = Plano::with(['turmas'])->find($plano->id);
            if ($resultado) {
                $rest = new ResponseTemplate(201);
                $response = $rest->build();
                return Response::json($response, $rest->getStatus()['code']);
            }
            $rest = new ResponseTemplate(500);
            $response = $rest->build(['message' => 'Falha inesperada ao registrar novo plano.']);
            return Response::json($response, $rest->getStatus()['code']);
        } catch (Exception $e) {
            $rest = new ResponseTemplate(500);
            $response = $rest->build(['message' => $e->getMessage()]);
            return Response::json($response, $rest->getStatus()['code']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function detalhar(string $id)
    {
        $plano = Plano::with('turmas')->find($id);
        if ($plano->isEmpty()) {
            $rest = new ResponseTemplate(404);
            $response = $rest->build(['message' => 'Nenhum plano cadastrado.']);
            return response()->json($response, $rest->getStatus()['code']);
        }
        $rest = new ResponseTemplate(200);
        $response = $rest->build($plano->toArray());
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
