<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TramiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tramites = [
            ['codigo' => 'OMR-001', 'nombre' => 'Declaración de Renta',           'descripcion' => 'Declaración anual de impuesto sobre la renta',        'institucion_id' => 1, 'dias_habiles' => 15],
            ['codigo' => 'OMR-002', 'nombre' => 'Solvencia Fiscal',               'descripcion' => 'Certificado de estar al día con el fisco',             'institucion_id' => 1, 'dias_habiles' => 5],
            ['codigo' => 'OMR-003', 'nombre' => 'Registro Sanitario',             'descripcion' => 'Registro de productos de consumo humano',              'institucion_id' => 2, 'dias_habiles' => 30],
            ['codigo' => 'OMR-004', 'nombre' => 'Permiso de Funcionamiento',      'descripcion' => 'Autorización para operar un establecimiento',          'institucion_id' => 2, 'dias_habiles' => 20],
            ['codigo' => 'OMR-005', 'nombre' => 'Solvencia Municipal SS',         'descripcion' => 'Constancia de no adeudo municipal San Salvador',       'institucion_id' => 3, 'dias_habiles' => 3],
            ['codigo' => 'OMR-006', 'nombre' => 'Permiso de Construcción SS',     'descripcion' => 'Autorización municipal para construir',                'institucion_id' => 3, 'dias_habiles' => 45],
            ['codigo' => 'OMR-007', 'nombre' => 'Solvencia Municipal ST',         'descripcion' => 'Constancia de no adeudo municipal Santa Tecla',        'institucion_id' => 4, 'dias_habiles' => 3],
            ['codigo' => 'OMR-008', 'nombre' => 'Licencia Comercial Santa Tecla', 'descripcion' => 'Licencia para actividad comercial en Santa Tecla',     'institucion_id' => 4, 'dias_habiles' => 10],
            ['codigo' => 'OMR-009', 'nombre' => 'Concesión Hídrica',              'descripcion' => 'Autorización para uso de recursos hídricos',           'institucion_id' => 5, 'dias_habiles' => 60],
            ['codigo' => 'OMR-010', 'nombre' => 'Permiso de Conexión Eléctrica',  'descripcion' => 'Aprobación para nueva conexión al sistema eléctrico',  'institucion_id' => 5, 'dias_habiles' => 25],
        ];

        foreach ($tramites as $t) {
            \App\Models\Tramite::create($t);
        }
    }
}
