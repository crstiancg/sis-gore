<?php

namespace App\Http\Controllers;

use App\Models\Tipo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TipoController extends Controller
{

    public function index(Request $request)
    {
        return $this->generateViewSetList(
            $request,
            Tipo::query(),
            [],
            ['id', 'nombre'],
            ['id', 'nombre']
        );
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $tipo = Tipo::create($request->all());
            
            DB::commit();
            return response($tipo, 201);
        } catch (\Exception $e) {
            DB::rollBack(); 
            return response()->json(['error' => 'Failed to create tipo', 'message' => $e->getMessage()], 500);
        }
    }

    public function show(Tipo $tipo)
    {
        return response()->json($tipo);
    }

    public function update(Request $request, Tipo $tipo)
    {
        DB::beginTransaction();

        try {

            $tipo->update($request->all());
            
            DB::commit();
            return response([$request, $tipo], 201);
        } catch (\Exception $e) {
            DB::rollBack(); 
            return response()->json(['error' => 'Failed to update tipo', 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy(Tipo $tipo)
    {
        return response()->json($tipo->delete());
    }
}
