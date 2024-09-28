<?php

namespace App\Http\Controllers;

use App\Models\Procedimiento;
use Illuminate\Http\Request;

class ProcedimientoController extends Controller
{
    
    public function index(Request $request)
    {
        return $this->generateViewSetList(
            $request,
            Procedimiento::query(),
            [],
            [],
            [],
        );
    }
}
