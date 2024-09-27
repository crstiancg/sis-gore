<?php

namespace Database\Seeders;

use App\Models\Entidad;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EntidadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $entidades = [
            ['nombre' => 'ALFIN BANCO', 'tipo' => 'BANCO'],
            ['nombre' => 'BBVA', 'tipo' => 'BANCO'],
            ['nombre' => 'BANCO BCI', 'tipo' => 'BANCO'],
            ['nombre' => 'BANCOM', 'tipo' => 'BANCO'],
            ['nombre' => 'BANCO DE CREDITO', 'tipo' => 'BANCO'],
            ['nombre' => 'NACION', 'tipo' => 'BANCO'],
            ['nombre' => 'BANCO FALABELLA', 'tipo' => 'BANCO'],
            ['nombre' => 'BANCO GNB', 'tipo' => 'BANCO'],
            ['nombre' => 'BANBIF', 'tipo' => 'BANCO'],
            ['nombre' => 'INTERBANK', 'tipo' => 'BANCO'],
            ['nombre' => 'BANCO PICHINCHA', 'tipo' => 'BANCO'],
            ['nombre' => 'BANCO RIPLEY', 'tipo' => 'BANCO'],
            ['nombre' => 'SANTANDER PERU', 'tipo' => 'BANCO'],
            ['nombre' => 'BANK OF CHINA (PERU)', 'tipo' => 'BANCO'],
            ['nombre' => 'CITIBANK DEL PERU', 'tipo' => 'BANCO'],
            ['nombre' => 'ICBC PERU BANK S.A.', 'tipo' => 'BANCO'],
            ['nombre' => 'MIBANCO', 'tipo' => 'BANCO'],
            ['nombre' => 'SCOTIABANK PERU', 'tipo' => 'BANCO'],
            ['nombre' => 'COMPARTAMOS FINANCIE', 'tipo' => 'FINANCIERA'],
            ['nombre' => 'CREDISCOTIA', 'tipo' => 'FINANCIERA'],
            ['nombre' => 'FINANCIERA CONFIANZA', 'tipo' => 'FINANCIERA'],
            ['nombre' => 'FINANC. CREDINKA', 'tipo' => 'FINANCIERA'],
            ['nombre' => 'FINANCIERA EFECTIVA', 'tipo' => 'FINANCIERA'],
            ['nombre' => 'FINANCIERA OH', 'tipo' => 'FINANCIERA'],
            ['nombre' => 'FINANC. PROEMPRESA', 'tipo' => 'FINANCIERA'],
            ['nombre' => 'FINANCIERA QAPAQ', 'tipo' => 'FINANCIERA'],
            ['nombre' => 'FINANCIERA SURGIR', 'tipo' => 'FINANCIERA'],
            ['nombre' => 'CMAC CUSCO', 'tipo' => 'CAJA MUNICIPAL AC'],
            ['nombre' => 'CMAC AREQUIPA', 'tipo' => 'CAJA MUNICIPAL AC'],
            ['nombre' => 'CMAC DEL SANTA', 'tipo' => 'CAJA MUNICIPAL AC'],
            ['nombre' => 'CMAC HUANCAYO', 'tipo' => 'CAJA MUNICIPAL AC'],
            ['nombre' => 'CMAC ICA', 'tipo' => 'CAJA MUNICIPAL AC'],
            ['nombre' => 'CMAC MAYNAS', 'tipo' => 'CAJA MUNICIPAL AC'],
            ['nombre' => 'CMAC PAITA', 'tipo' => 'CAJA MUNICIPAL AC'],
            ['nombre' => 'CMAC PIURA', 'tipo' => 'CAJA MUNICIPAL AC'],
            ['nombre' => 'CMAC TACNA', 'tipo' => 'CAJA MUNICIPAL AC'],
            ['nombre' => 'CMAC TRUJILLO', 'tipo' => 'CAJA MUNICIPAL AC'],
            ['nombre' => 'CMCP LIMA', 'tipo' => 'CAJA MUNICIPAL AC'],
            ['nombre' => 'CRAC CENCOSUD SCOTIA', 'tipo' => 'CAJA RURAL AC'],
            ['nombre' => 'CRAC LOS ANDES', 'tipo' => 'CAJA RURAL AC'],
            ['nombre' => 'CRAC DEL CENTRO', 'tipo' => 'CAJA RURAL AC'],
            ['nombre' => 'CRAC PRYMERA', 'tipo' => 'CAJA RURAL AC'],
            ['nombre' => 'CRAC INCASUR', 'tipo' => 'CAJA RURAL AC'],
        ];
        Entidad::insert($entidades);
    }
}
