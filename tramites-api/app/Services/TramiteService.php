<?php

namespace App\Services;

use App\Models\Tramite;

class TramiteService
{
    public function getPaginated(?int $institucionId)
    {
        return Tramite::with('institucion')
            ->when($institucionId, fn($q) => $q->where('institucion_id', $institucionId))
            ->paginate(10);
    }

    public function getById(int $id): Tramite
    {
        return Tramite::with('institucion')->findOrFail($id);
    }

    public function create(array $data): Tramite
    {
        return Tramite::create($data);
    }

    public function update(Tramite $tramite, array $data): Tramite
    {
        $tramite->update($data);
        return $tramite->fresh('institucion');
    }

    public function deactivate(Tramite $tramite): Tramite
    {
        $tramite->update(['activo' => false]);
        return $tramite->fresh('institucion');
    }
}