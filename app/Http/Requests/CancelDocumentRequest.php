<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CancelDocumentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->hasAnyRole(['admin', 'operator']) ?? false;
    }

    public function rules(): array
    {
        return ['motivo_anulacion' => ['required', 'string', 'min:10', 'max:500']];
    }
}
