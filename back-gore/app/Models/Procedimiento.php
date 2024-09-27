<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Procedimiento extends Model
{
    use HasFactory;

    protected $connection = 'mysql2';
    protected $table = 'prg_procedimiento';
    protected $primaryKey = 'idprocedim';
}
