<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTramiteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'codigo'         => 'sometimes|string|max:20|unique:tramites,codigo,' . $this->route('tramite'),
            'nombre'         => 'sometimes|string|max:255',
            'descripcion'    => 'nullable|string',
            'institucion_id' => 'sometimes|exists:instituciones,id',
            'dias_habiles'   => 'sometimes|integer|min:1',
        ];
    }
}
