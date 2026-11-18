<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class ForgotPasswordController extends Controller
{
    /**
     * Muestra la vista de solicitud de enlace de recuperación.
     */
    public function showLinkRequestForm(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Envía el correo con el enlace de recuperación a la dirección especificada.
     */
    public function sendResetLinkEmail(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ], [
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Por favor, ingrese una dirección de correo válida.',
        ]);

        // Intentar enviar el enlace de recuperación de contraseña de Laravel
        $status = Password::broker()->sendResetLink(
            $request->only('email')
        );

        $messages = [
            Password::RESET_LINK_SENT => 'Hemos enviado el enlace de recuperación de contraseña a su correo electrónico.',
            Password::INVALID_USER => 'No encontramos ningún usuario registrado con esa dirección de correo electrónico.',
            Password::RESET_THROTTLED => 'Por favor, espere unos momentos antes de solicitar otro enlace.',
        ];

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('status', $messages[$status]);
        }

        throw ValidationException::withMessages([
            'email' => [$messages[$status] ?? __($status)],
        ]);
    }
}
