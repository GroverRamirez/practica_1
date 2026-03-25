<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Muestra el formulario de registro para crear nuevos usuarios.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Valida los datos, crea el usuario, inicia sesión y redirige al dashboard.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Se guarda la contraseña cifrada antes de persistir el nuevo usuario.
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Este evento permite que Laravel ejecute acciones asociadas al registro.
        event(new Registered($user));

        // Después del registro se abre la sesión automáticamente para entrar al panel.
        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
