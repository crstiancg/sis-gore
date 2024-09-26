<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Oficio extends Model
{
    use HasFactory;

    protected $fillable = ['nombre'];

    public function papeletas()
    {
        return $this->hasMany(Papeleta::class);
    }
}
