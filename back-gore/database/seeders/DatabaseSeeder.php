<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\TipoContenedor;
use App\Models\TipoDocumento;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call([
            ClientTokenSeeder::class, 
            AreaSeeder::class, 
            PermisoSeeder::class, 
            UbigeoSeeder::class,
            TipoSeeder::class,
            EntidadSeeder::class,
        ]);
    }
}
