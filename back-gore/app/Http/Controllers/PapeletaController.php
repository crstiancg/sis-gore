<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePapeletasRequest;
use App\Models\Papeleta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PapeletaController extends Controller
{
   
    public function index()
    {
        //
    }

    public function store(StorePapeletasRequest $request)
    {
        try{
            $ruta = null;
            if ($request->hasFile('archivo')) {
                $file = $request->file('archivo');
                $newName = $this->nuevoNombre( $file->getClientOriginalName());
                $path = Storage::putFileAs('public/archivos', $file, $newName); //alacenar en storage el archivo
                $ruta = env('APP_URL') . 'storage/archivos/' . pathinfo($path, PATHINFO_BASENAME);
            }

            $papeleta = Papeleta::create([
                'persona_id' => $request->persona_id,
                'tipo_id' => $request->tipo_id,
                'archivo' => $ruta,
                'observacion' => $request->observacion,
            ]);

            DB::commit();

            return response()->json([$papeleta], 201);

        }catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'No se pudo registrar el documento y el interesado.'], 500);
        }
        return response(Papeleta::create($request->all()), 201);
    }

    public function show(Papeleta $papeleta)
    {
        //
    }

    public function update(Request $request, Papeleta $papeleta)
    {
        //
    }

    public function destroy(Papeleta $papeleta)
    {
        //
    }
}
