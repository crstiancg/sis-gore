<?php

namespace App\Http\Controllers;

use App\Models\Carta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
class CartaController extends Controller
{
  
    public function index(Request $request)
    {
        return $this->generateViewSetList(
            $request,
            Carta::query(),
            [],
            ['monto','dependencia','contratista'],
            [''],
        );
    }

    public function store(Request $request)
    {
        try{
            DB::beginTransaction();

            $cartaFianza = Carta::create($request->all());

            DB::commit();
        
            return response()->json($cartaFianza, 201);

        }catch(Exception $e){
            DB::rollBack();

            return response()->json(['error' => 'Ocurrió un error al crear la Carta Fianza: ' . $e->getMessage() . ' en la línea ' . $e->getLine()], 500);
        }
    }

    public function show(Carta $carta)
    {
        return response()->json($carta);
    }

    public function update(Request $request, Carta $carta)
    {
        try {
            DB::beginTransaction();
    
            $carta->update($request->all());
    
            DB::commit();
    
            return response()->json($carta, 200);
    
        } catch (Exception $e) {
            DB::rollBack();
    
            return response()->json(['error' => 'Ocurrió un error al actualizar la Carta Fianza: ' . $e->getMessage() . ' en la línea ' . $e->getLine()], 500);
        }
    }

    public function destroy(Carta $carta)
    {
        return response($carta->delete());
    }

    public function cartasv(Request $request)
    {
        $dias = $request->input('fecha') ? $request->input('fecha') : 10;

        // Obtiene cartas cuyas renovaciones vencen en los próximos "n" días, vencen hoy o ya vencieron
        $cartasPorVencer = Carta::whereHas('renovacions', function ($query) use ($dias) {
            $query->whereRaw('DATEDIFF(fecha_vencimiento, CURDATE()) <= ?', [$dias]) // Cartas que vencen en los próximos días
                  ->orWhereRaw('DATEDIFF(fecha_vencimiento, CURDATE()) = 0')          // Cartas que vencen hoy
                  ->orWhereRaw('DATEDIFF(fecha_vencimiento, CURDATE()) < 0');         // Cartas que ya vencieron
        })
        ->with(['renovacions' => function ($query) use ($dias) {
            $query->whereRaw('DATEDIFF(fecha_vencimiento, CURDATE()) <= ?', [$dias]) // Cartas que vencen en los próximos días
                  ->orWhereRaw('DATEDIFF(fecha_vencimiento, CURDATE()) = 0')          // Cartas que vencen hoy
                  ->orWhereRaw('DATEDIFF(fecha_vencimiento, CURDATE()) < 0');         // Cartas que ya vencieron
        }])->get();
    
        return response()->json($cartasPorVencer);
    }
}
