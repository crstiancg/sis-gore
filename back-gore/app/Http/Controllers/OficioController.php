<?php

namespace App\Http\Controllers;

use App\Models\Oficio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OficioController extends Controller
{
    
    public function index(Request $request)
    {
        return $this->generateViewSetList(
            $request,
            Oficio::query(),
            [],
            [],
            [],
        );
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $persona = Oficio::create($request->all());
            
            DB::commit();
            return response($persona, 201);
        } catch (\Exception $e) {
            DB::rollBack(); 
            return response()->json(['error' => 'Failed to create Oficio', 'message' => $e->getMessage()], 500);
        }
    }

    public function show(Oficio $oficio)
    {
        return response()->json($oficio);
    }

    public function update(Request $request, Oficio $oficio)
    {
        DB::beginTransaction();

        try {

            $oficio->update($request->all());
            
            DB::commit();
            return response([$request, $oficio], 201);
        } catch (\Exception $e) {
            DB::rollBack(); 
            return response()->json(['error' => 'Failed to update Oficio', 'message' => $e->getMessage()], 500);
        }
    }
    
    public function destroy(Oficio $oficio)
    {
        return response()->json($oficio->delete());
    }
}
