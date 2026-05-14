<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInstitucionRequest;
use App\Http\Resources\InstitucionResource;
use App\Services\InstitucionService;

class InstitucionController extends Controller
{
    public function __construct(protected InstitucionService $service) {}

    public function index()
    {
        return InstitucionResource::collection($this->service->getAll());
    }

    public function store(StoreInstitucionRequest $request)
    {
        $institucion = $this->service->create($request->validated());
        return new InstitucionResource($institucion);
    }
}
