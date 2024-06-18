<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Modalidade;
use Illuminate\Http\Request;
use RESTfulTemplate\ResponseTemplate;

class ModalidadesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
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
    public function store(Request $request)
    {
        //
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
