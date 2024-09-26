<?php

namespace App\Http\Controllers;

use App\Models\Entidad;
use Illuminate\Http\Request;

class EntidadController extends Controller
{

    public function index(Request $request)
    {
        return $this->generateViewSetList(
            $request,
            Entidad::query(),
            [],
            ['nombre'],
            [],
        );
    }

    public function store(Request $request)
    {
        return response(Entidad::create($request->all()), 201);
    }

    public function show(Entidad $entidad)
    {
        return response()->json($entidad);
    }

    public function update(Request $request, Entidad $entidad)
    {
        $entidad->update($request->all());

        return response()->json([$request, $entidad]);
    }

    public function destroy(Entidad $entidad)
    {
        return response()->json($entidad->delete());
    }
}
