<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entidad extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre'
    ];

    public function renovacions()
    {
        return $this->hasMany(Renovacion::class);
    }
}
