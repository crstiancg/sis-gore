<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    use HasFactory;

    protected $with = ['papeletas'];

    protected $fillable = [
        'dni',
        'ruc',
        'rsocial',
        'nombre',
        'paterno',
        'materno',
        'nombre_completo',
        'tipo_documento'
    ];

    public function papeletas()
    {
        return $this->hasMany(Papeleta::class);
    }
}
