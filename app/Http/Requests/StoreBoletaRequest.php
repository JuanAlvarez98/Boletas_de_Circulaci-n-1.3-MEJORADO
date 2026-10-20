<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBoletaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->hasAnyRole(['admin', 'operator']) ?? false;
    }

    public function rules(): array
    {
        return [
            'vehicle_id' => ['required', 'exists:vehicles,id'],
            'fecha_emision' => ['required', 'date'],
            'fecha_vigencia' => ['required', 'date', 'after_or_equal:fecha_emision'],
            'observaciones' => ['nullable', 'string', 'max:500'],
        ];
    }
}
