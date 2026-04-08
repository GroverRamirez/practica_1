<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Iniciar sesión | {{ config('app.name', 'Laravel') }}</title>

    <!-- Usando Bootstrap CDN y Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Fuente Inter (Google Fonts) para homogeneizar con el panel -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- CSS del Tema Premium General -->
    <link rel="stylesheet" href="{{ asset('css/estilo.css') }}">

    <style>
        body {
            /* Fondo Slate idéntico al del panel */
            background-color: #f1f5f9;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .login-card {
            border: 0;
            border-radius: 1.5rem;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(15, 23, 42, 0.1);
        }

        /* Reutilizamos conceptualmente el gradiente Navy de la App */
        .login-brand {
            background: linear-gradient(170deg, rgba(15, 23, 42, 0.95) 0%, rgba(30, 41, 59, 0.98) 100%);
            color: #fff;
            position: relative;
        }

        .login-brand::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3z' fill='%23ffffff' fill-opacity='0.03' fill-rule='evenodd'/%3E%3C/svg%3E");
            pointer-events: none;
        }

        .login-brand .badge {
            letter-spacing: 0.05em;
            background-color: rgba(255, 255, 255, 0.1) !important;
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #fff !important;
        }

        /* Ajustes específicos para los inputs en el login */
        .form-control-lg {
            font-size: 0.95rem;
            padding: 0.75rem 1rem;
        }
    </style>
</head>

<body>
    <div class="container py-5">
        <div class="row justify-content-center w-100 m-0">
            <div class="col-12 col-lg-10 col-xl-9">
                <div class="card login-card bg-white">
                    <div class="row g-0 h-100">
                        {{-- COLUMNA IZQUIERDA: DISEÑO PREMIUM NAVY (MINIMALISTA) --}}
                        <div
                            class="col-lg-5 d-none d-lg-flex flex-column justify-content-center align-items-center p-5 login-brand text-center">
                            <div class="position-relative" style="z-index: 2;">
                                <div class="mb-4">
                                    <i class="bi bi-heptagon-fill"
                                        style="font-size: 3.5rem; color: #60a5fa; filter: drop-shadow(0 0 15px rgba(96,165,250,0.5));"></i>
                                </div>
                                <h1 class="display-6 fw-bold mb-2" style="letter-spacing: -0.02em;">
                                    App Web
                                </h1>
                                <p class="text-white-50" style="font-size: 1.1rem; font-weight: 300;">
                                    Panel Administrativo
                                </p>
                            </div>
                        </div>

                        {{-- COLUMNA DERECHA: FORMULARIO SÓLIDO Y LIMPIO --}}
                        <div class="col-lg-7 d-flex align-items-center bg-white">
                            <div class="p-4 p-md-5 w-100">

                                <div
                                    class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4 pb-2 border-bottom">
                                    <h2 class="h4 fw-bold mb-0 text-dark">Ingresar</h2>
                                    <a href="{{ route('welcome') }}"
                                        class="btn btn-soft-secondary btn-sm d-inline-flex align-items-center gap-1">
                                        <i class="bi bi-arrow-left"></i> Volver
                                    </a>
                                </div>

                                @if (session('status'))
                                    <div class="alert alert-success alert-dismissible fade show border-0 panel-card shadow-sm"
                                        role="alert">
                                        <i class="bi bi-check-circle-fill me-2"></i> {{ session('status') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('login') }}" class="mt-4">
                                    @csrf

                                    <div class="mb-4">
                                        <label for="email" class="form-label fw-medium text-secondary">Correo
                                            Electrónico</label>
                                        <div class="input-group product-search-group shadow-sm">
                                            <span class="input-group-text bg-white border-end-0 text-muted">
                                                <i class="bi bi-envelope"></i>
                                            </span>
                                            <input id="email" type="email" name="email" value="{{ old('email') }}"
                                                class="form-control form-control-lg border-start-0 ps-0 @error('email') is-invalid @enderror"
                                                placeholder="tu@correo.com" required autofocus autocomplete="username">
                                        </div>
                                        @error('email')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <label for="password"
                                                class="form-label fw-medium text-secondary mb-0">Contraseña</label>
                                            @if (Route::has('password.request'))
                                                <a class="text-primary-theme text-decoration-none"
                                                    href="{{ route('password.request') }}" style="font-size: 0.85rem;">
                                                    ¿Olvidaste tu contraseña?
                                                </a>
                                            @endif
                                        </div>
                                        <div class="input-group product-search-group shadow-sm mt-2">
                                            <span class="input-group-text bg-white border-end-0 text-muted">
                                                <i class="bi bi-key"></i>
                                            </span>
                                            <input id="password" type="password" name="password"
                                                class="form-control form-control-lg border-start-0 ps-0 @error('password') is-invalid @enderror"
                                                placeholder="••••••••" required autocomplete="current-password">
                                        </div>
                                        @error('password')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <div class="form-check">
                                            <input id="remember_me" type="checkbox" class="form-check-input"
                                                name="remember">
                                            <label class="form-check-label text-secondary" for="remember_me"
                                                style="font-size: 0.9rem;">
                                                Mantenerme conectado
                                            </label>
                                        </div>
                                    </div>

                                    <div class="d-grid mb-4">
                                        <button type="submit" class="btn btn-primary-theme btn-lg fw-medium shadow-sm">
                                            Ingresar
                                        </button>
                                    </div>

                                    <div class="text-center mt-3">
                                        <p class="text-secondary mb-0" style="font-size: 0.9rem;">
                                            ¿No tienes una cuenta?
                                            <a href="{{ route('register') }}"
                                                class="text-primary-theme text-decoration-none fw-semibold">
                                                Regístrate
                                            </a>
                                        </p>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>