<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TramiteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'           => $this->id,
            'codigo'       => $this->codigo,
            'nombre'       => $this->nombre,
            'descripcion'  => $this->descripcion,
            'dias_habiles' => $this->dias_habiles,
            'activo'       => $this->activo,
            'institucion'  => new InstitucionResource($this->whenLoaded('institucion')),
        ];
    }
}
