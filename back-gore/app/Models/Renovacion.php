<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Renovacion extends Model
{
    use HasFactory;


    protected $table = 'renovacions';

    protected $with = ['entidad'];

    protected $fillable = [
        'anio',
        'tipo',
        'numero_llegada',
        'fecha_incial',
        'fecha_vencimiento',
        'numero_carta',
        'folios',
        'oficio_notificado',
        'tipo_proceso',
        'oficio_efectivizacion',
        'estado_carta',
        'entidad_id',
        'carta_id'
        ];
        
    public function carta()
    {
        return $this->belongsTo(Carta::class,'carta_id');
    }

    public function entidad()
    {
        return $this->belongsTo(Entidad::class);
    }
}
