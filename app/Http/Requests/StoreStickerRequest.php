<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreStickerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->hasAnyRole(['admin', 'operator']) ?? false;
    }

    public function rules(): array
    {
        return [
            'vehicle_id' => ['required', 'exists:vehicles,id'],
            'boleta_id' => [
                'nullable',
                Rule::exists('boletas_circulacion', 'id')->where(fn ($query) => $query
                    ->where('vehicle_id', $this->integer('vehicle_id'))
                    ->where('estado', 'vigente')),
            ],
        ];
    }

    public function messages(): array
    {
        return ['boleta_id.exists' => 'La boleta debe estar vigente y pertenecer al vehículo seleccionado.'];
    }
}
