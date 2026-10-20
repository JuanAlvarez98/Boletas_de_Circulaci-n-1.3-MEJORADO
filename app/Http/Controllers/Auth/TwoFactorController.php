<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\TwoFactorCodeMail;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class TwoFactorController extends Controller
{
    public function showForm(Request $request): View|RedirectResponse
    {
        if (! $request->session()->has('auth.2fa.id')) {
            return redirect()->route('login');
        }
        $user = User::findOrFail($request->session()->get('auth.2fa.id'));
        $isAppBased = ! empty($user->two_factor_secret);

        return view('auth.two-factor', compact('isAppBased', 'user'));
    }

    public function verify(Request $request): RedirectResponse
    {
        if (! $request->session()->has('auth.2fa.id')) {
            return redirect()->route('login');
        }
        $request->validate(['code' => ['required', 'digits:6']]);
        $user = User::findOrFail($request->session()->get('auth.2fa.id'));
        $key = '2fa:'.$user->id.'|'.$request->ip();
        if (RateLimiter::tooManyAttempts($key, 5)) {
            throw ValidationException::withMessages(['code' => 'Demasiados intentos. Intente nuevamente en '.RateLimiter::availableIn($key).' segundos.']);
        }

        $valid = $user->two_factor_secret
            ? $this->verifyTotp($user->two_factor_secret, $request->string('code'))
            : $user->two_factor_code && $user->two_factor_expires_at?->isFuture() && Hash::check($request->string('code'), $user->two_factor_code);
        if (! $valid) {
            RateLimiter::hit($key, 300);
            $user->increment('two_factor_attempts');
            throw ValidationException::withMessages(['code' => 'El código es incorrecto o ha expirado.']);
        }

        RateLimiter::clear($key);
        $user->forceFill(['two_factor_code' => null, 'two_factor_expires_at' => null, 'two_factor_sent_at' => null, 'two_factor_attempts' => 0])->save();
        Auth::login($user, $request->session()->get('auth.2fa.remember', false));
        $request->session()->forget(['auth.2fa.id', 'auth.2fa.remember']);
        $request->session()->regenerate();

        return redirect()->intended('/dashboard');
    }

    public function resend(Request $request): RedirectResponse
    {
        if (! $request->session()->has('auth.2fa.id')) {
            return redirect()->route('login');
        }
        $user = User::findOrFail($request->session()->get('auth.2fa.id'));
        if ($user->two_factor_secret) {
            return back()->withErrors(['code' => 'Use el código de su aplicación autenticadora.']);
        }
        if ($user->two_factor_sent_at?->gt(now()->subMinute())) {
            return back()->withErrors(['code' => 'Espere un minuto antes de solicitar un código nuevo.']);
        }
        $code = (string) random_int(100000, 999999);
        $user->forceFill(['two_factor_code' => Hash::make($code), 'two_factor_expires_at' => now()->addMinutes(10),
            'two_factor_sent_at' => now(), 'two_factor_attempts' => 0])->save();
        Mail::to($user->email)->send(new TwoFactorCodeMail($code));

        return back()->with('status', 'Se envió un código nuevo. El código anterior dejó de ser válido.');
    }

    protected function verifyTotp(string $secret, string $code): bool
    {
        $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';
        $secret = str_replace('=', '', strtoupper($secret));
        $bits = '';
        foreach (str_split($secret) as $char) {
            $pos = strpos($alphabet, $char);
            if ($pos === false) {
                return false;
            } $bits .= sprintf('%05b', $pos);
        }
        $key = '';
        foreach (str_split($bits, 8) as $byte) {
            if (strlen($byte) === 8) {
                $key .= chr(bindec($byte));
            }
        }
        $slice = (int) floor(time() / 30);
        for ($i = -1; $i <= 1; $i++) {
            $hash = hash_hmac('sha1', pack('N*', 0).pack('N*', $slice + $i), $key, true);
            $offset = ord($hash[19]) & 0xF;
            $otp = (((ord($hash[$offset]) & 0x7F) << 24) | ((ord($hash[$offset + 1]) & 0xFF) << 16) | ((ord($hash[$offset + 2]) & 0xFF) << 8) | (ord($hash[$offset + 3]) & 0xFF)) % 1000000;
            if (hash_equals(str_pad((string) $otp, 6, '0', STR_PAD_LEFT), (string) $code)) {
                return true;
            }
        }

        return false;
    }
}
