<?php

namespace Database\Seeders;

use App\Models\Tipo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tipo::updateOrCreate([
            'nombre' => 'M01',
        ]);
        Tipo::updateOrCreate([
            'nombre' => 'M02',
        ]);
        Tipo::updateOrCreate([
            'nombre' => 'M03',
        ]);
        Tipo::updateOrCreate([
            'nombre' => 'M04',
        ]);
        Tipo::updateOrCreate([
            'nombre' => 'M05',
        ]);
    }
}
