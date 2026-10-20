<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Mail\TwoFactorCodeMail;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->authenticate();
        $field = array_key_first($credentials);
        $user = User::where($field, $credentials[$field])->firstOrFail();
        if ($user->disabled_at) {
            throw ValidationException::withMessages(['login' => 'Esta cuenta está desactivada. Contacte al administrador.']);
        }

        $request->session()->regenerate();
        $request->session()->put(['auth.2fa.id' => $user->id, 'auth.2fa.remember' => $request->boolean('remember')]);
        if (! $user->two_factor_secret) {
            $this->sendEmailTwoFactorCode($user);
        }

        return redirect()->route('auth.two-factor');
    }

    protected function sendEmailTwoFactorCode(User $user): void
    {
        $code = (string) random_int(100000, 999999);
        $user->forceFill(['two_factor_code' => Hash::make($code), 'two_factor_expires_at' => now()->addMinutes(10),
            'two_factor_sent_at' => now(), 'two_factor_attempts' => 0])->save();
        Mail::to($user->email)->send(new TwoFactorCodeMail($code));
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
