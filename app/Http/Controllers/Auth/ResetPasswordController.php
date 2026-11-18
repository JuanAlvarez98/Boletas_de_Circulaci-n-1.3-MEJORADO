<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password as PasswordRule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class ResetPasswordController extends Controller
{
    /**
     * Muestra la vista para restablecer la contraseña.
     */
    public function showResetForm(Request $request, ?string $token = null): View
    {
        return view('auth.reset-password')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    /**
     * Procesa la solicitud de restablecimiento de contraseña.
     */
    public function reset(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => [
                'required',
                'confirmed',
                // Aplicar políticas estrictas de complejidad de contraseñas
                PasswordRule::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
            ],
        ], [
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Por favor, ingrese un correo válido.',
            'password.required' => 'La nueva contraseña es obligatoria.',
            'password.confirmed' => 'La confirmación de la contraseña no coincide.',
            'password.min' => 'La contraseña debe tener al menos :min caracteres.',
            'password.mixed' => 'La contraseña debe incluir al menos una letra mayúscula y una minúscula.',
            'password.letters' => 'La contraseña debe incluir al menos una letra.',
            'password.numbers' => 'La contraseña debe incluir al menos un número.',
            'password.symbols' => 'La contraseña debe incluir al menos un carácter especial.',
        ]);

        // Intentar restablecer la contraseña usando el broker nativo de Laravel
        $status = Password::broker()->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    // Hash seguro (Laravel usa Bcrypt o Argon2 por defecto según config/hashing.php)
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        $messages = [
            Password::PASSWORD_RESET => 'Su contraseña ha sido restablecida correctamente.',
            Password::INVALID_TOKEN => 'Este enlace o token de restablecimiento de contraseña no es válido o ha expirado.',
            Password::INVALID_USER => 'No encontramos ningún usuario registrado con esa dirección de correo electrónico.',
            Password::RESET_THROTTLED => 'Por favor, espere unos momentos antes de volver a intentarlo.',
        ];

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('status', $messages[$status]);
        }

        throw ValidationException::withMessages([
            'email' => [$messages[$status] ?? __($status)],
        ]);
    }
}
