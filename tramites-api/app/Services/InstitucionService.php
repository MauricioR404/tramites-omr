<?php

namespace App\Services;

use App\Models\Institucion;

class InstitucionService
{
    public function getAll()
    {
        return Institucion::where('activo', true)->get();
    }

    public function create(array $data): Institucion
    {
        return Institucion::create($data);
    }
}