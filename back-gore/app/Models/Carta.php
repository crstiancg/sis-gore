<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carta extends Model
{
    use HasFactory;

    protected $table = 'cartas';
    protected $with = ['meta','renovacions'];
    protected $fillable = [
        'monto',
        'contratista',
        'dependencia',
        'denominacion',
        'meta_id',

    ];
    // public function meta()
    // {
    //     return $this->belongsTo(Meta::class, 'meta_id');
    // }

    public function addBusinessDays($date, $days) {
        $carbonDate = Carbon::parse($date);
    
        while ($days > 0) {
            $carbonDate->addDay();
    
            // Si es fin de semana, no contamos este día
            if ($carbonDate->isWeekend()) {
                continue;
            }
    
            // Si es un día festivo, no contamos este día
            if (in_array($carbonDate->format('Y-m-d'), Carta::getHolidays($carbonDate->format('Y')))) {
                continue;
            }
    
            // Decrementamos los días restantes
            $days--;
        }
        $this->fecha_respuesta = $carbonDate->format('Y-m-d');
        $this->save();
        // return $carbonDate->format('Y-m-d');
    }
    public static function getHolidays($year)
    {
        $holidays = [
            "{$year}-01-01",  // Año Nuevo
            "{$year}-04-18",  // Jueves Santo
            "{$year}-04-19",  // Viernes Santo
            "{$year}-05-01",  // Día del Trabajo
            "{$year}-06-29",  // Fiesta de San Pedro y San Pablo
            "{$year}-07-28",  // Fiesta Nacional del Perú
            "{$year}-07-29",  // Fiesta Nacional del Perú (continuación)
            "{$year}-08-30",  // Santa Rosa de Lima
            "{$year}-10-08",  // Combate de Angamos
            "{$year}-11-01",  // Todos los Santos
            "{$year}-12-08",  // Inmaculada Concepción
            "{$year}-12-25",  // Navidad
        ];
        return array_filter($holidays, function ($date) use ($year) {
            return strpos($date, $year) === 0;
        });
    }


    public function renovacions()
    {
        return $this->hasMany(Renovacion::class);
    }
}
