<?php

namespace App\Http\Controllers;

use App\Models\Renovacion;
use Illuminate\Http\Request;

class RenovacionController extends Controller
{
    public function index(Request $request)
    {
        return $this->generateViewSetList(
            $request,
            Renovacion::query()->orderBy('created_at', 'desc'),
            [],
            [],
            [],
        );
    
    }

    public function store(Request $request)
    {
        return response(Renovacion::create($request->all()), 201);
    }

    public function show(Renovacion $renovacion)
    {
        return response()->json($renovacion);
    }

    public function update(Request $request, Renovacion $renovacion)
    {
        $renovacion->update($request->all());

        return response()->json([$request, $renovacion]);
    }

    public function destroy(Renovacion $renovacion)
    {
        return response()->json($renovacion->delete());
    }

    public function showrenovacion(Renovacion $renovacion)
    {
        return response()->json($renovacion);
    }
}
