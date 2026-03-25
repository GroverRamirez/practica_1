<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Cualquier invitado puede intentar autenticarse desde el formulario de login.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas minimas para validar el formulario antes de consultar la base de datos.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Intenta autenticar al usuario con email y contraseña.
     * Si falla, suma un intento al limitador para frenar ataques por fuerza bruta.
     *
     * @throws ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        if (! Auth::attempt($this->only('email', 'password'), $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                // El error se devuelve asociado al email para mostrarlo en la vista.
                'email' => trans('auth.failed'),
            ]);
        }

        // Si el acceso fue correcto, se reinicia el contador de intentos fallidos.
        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Bloquea temporalmente el login cuando se superan demasiados intentos fallidos.
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
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Construye una clave unica por correo e IP para limitar intentos.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('email')).'|'.$this->ip());
    }
}
