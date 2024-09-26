<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Papeleta extends Model
{
    use HasFactory;

    protected $with = ['tipo'];

    protected $fillable = [
        'persona_id',
        'tipo_id',
        'oficio_id',
        'archivo',
        'observacion',
        'fecha',
        'placa',
        'papeleta',
    ];

    public function persona()
    {
        return $this->belongsTo(Persona::class);
    }
    public function tipo()
    {
        return $this->belongsTo(Tipo::class);
    }

    public function oficio()
    {
        return $this->belongsTo(Oficio::class);
    }
}
