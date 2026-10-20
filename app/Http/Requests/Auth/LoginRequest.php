<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'login' => ['required', 'string'], // Acepta tanto usuario como correo institucional
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'login.required' => 'El nombre de usuario o correo institucional es obligatorio.',
            'password.required' => 'La contraseña es obligatoria.',
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws ValidationException
     */
    public function authenticate(): array
    {
        $this->ensureIsNotRateLimited();

        // Determinar si es un correo o un nombre de usuario
        $loginType = filter_var($this->input('login'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $credentials = [
            $loginType => $this->input('login'),
            'password' => $this->input('password'),
        ];

        // Intentar autenticación tentativa
        if (! Auth::validate($credentials)) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'login' => 'Estas credenciales no coinciden con nuestros registros o el usuario no existe.',
            ]);
        }

        // Si las credenciales son válidas, limpiamos los intentos del limitador
        RateLimiter::clear($this->throttleKey());

        // Retornamos las credenciales validadas para que el controlador proceda con el 2FA
        return $credentials;
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'login' => "Demasiados intentos de inicio de sesión. Por favor, intente de nuevo en {$seconds} segundos.",
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->input('login')).'|'.$this->ip());
    }
}
