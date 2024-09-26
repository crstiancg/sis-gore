<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePersonaRequest extends FormRequest
{
  
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // 'dni' => 'required',
            // 'nombre' => 'required',
            // 'paterno' => 'required',
            // 'materno' => 'required',
            'tipo_documento' => 'required',
        ];
    }
}
