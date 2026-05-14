<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTramiteRequest;
use App\Http\Requests\UpdateTramiteRequest;
use App\Http\Resources\TramiteResource;
use App\Services\TramiteService;
use Illuminate\Http\Request;

class TramiteController extends Controller
{
    public function __construct(protected TramiteService $service) {}

    public function index(Request $request)
    {
        $tramites = $this->service->getPaginated($request->integer('institucion_id') ?: null);
        return TramiteResource::collection($tramites);
    }

    public function show(int $id)
    {
        return new TramiteResource($this->service->getById($id));
    }

    public function store(StoreTramiteRequest $request)
    {
        $tramite = $this->service->create($request->validated());
        return new TramiteResource($tramite->load('institucion'));
    }

    public function update(UpdateTramiteRequest $request, int $id)
    {
        $tramite = $this->service->getById($id);
        return new TramiteResource($this->service->update($tramite, $request->validated()));
    }

    public function destroy(int $id)
    {
        $tramite = $this->service->getById($id);
        return new TramiteResource($this->service->deactivate($tramite));
    }
}