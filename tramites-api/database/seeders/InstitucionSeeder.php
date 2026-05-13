<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InstitucionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $instituciones = [
            ['nombre' => 'Ministerio de Hacienda',                'tipo' => 'MINISTERIO'],
            ['nombre' => 'Ministerio de Salud',                   'tipo' => 'MINISTERIO'],
            ['nombre' => 'Alcaldía de San Salvador',              'tipo' => 'ALCALDIA'],
            ['nombre' => 'Alcaldía de Santa Tecla',               'tipo' => 'ALCALDIA'],
            ['nombre' => 'CEL - Comisión Ejecutiva Hidroeléctrica','tipo' => 'AUTONOMA'],
        ];

        foreach ($instituciones as $inst) {
            \App\Models\Institucion::create($inst);
        }  
    }
}
