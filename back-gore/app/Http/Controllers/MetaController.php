<?php

namespace App\Http\Controllers;

use App\Models\Meta;
use Illuminate\Http\Request;

class MetaController extends Controller
{
    public function index(Request $request)
    {
        return $this->generateViewSetList(
            $request,
            Meta::query()->where('anio', 2024),
            [],
            ['codmeta', 'desmeta'],
            [],
        );
    }
}
