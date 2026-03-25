<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Muestra el formulario de acceso para usuarios invitados.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Valida las credenciales, autentica al usuario y renueva la sesión
     * para evitar fijación de sesión antes de entrar al panel privado.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // LoginRequest concentra la validación y el intento de autenticación.
        $request->authenticate();

        // regenerate() crea un nuevo identificador de sesión tras el login correcto.
        $request->session()->regenerate();

        // intended() respeta la URL privada que el usuario intentó abrir antes del login.
        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Cierra la sesión actual y limpia los datos de autenticación del navegador.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Se cierra la sesión del guard web, que es el guard por defecto de Laravel.
        Auth::guard('web')->logout();

        // invalidate() descarta la sesión anterior para que no pueda reutilizarse.
        $request->session()->invalidate();

        // Se genera un nuevo token CSRF para futuras peticiones como invitado.
        $request->session()->regenerateToken();

        // El usuario vuelve a la portada pública del proyecto.
        return redirect()->route('welcome');
    }
}
