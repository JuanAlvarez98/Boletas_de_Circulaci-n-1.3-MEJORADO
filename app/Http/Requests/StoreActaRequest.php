<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreActaRequest extends FormRequest
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
            'entrega_nombre' => ['required', 'string', 'max:150'],
            'recibe_nombre' => ['required', 'string', 'max:150'],
            'recibe_identidad' => ['nullable', 'string', 'max:30'],
            'recibe_email' => ['nullable', 'email', 'max:150'],
            'enviar_correo' => ['nullable', 'boolean'],
            'fecha_entrega' => ['required', 'date', 'before_or_equal:today'],
            'observaciones' => ['nullable', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'boleta_id.exists' => 'La boleta debe estar vigente y pertenecer al vehículo seleccionado.',
            'recibe_email.email' => 'El formato del correo electrónico ingresado no es válido.',
        ];
    }
}
