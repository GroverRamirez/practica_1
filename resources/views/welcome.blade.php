<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'GZ-Dash') }} - Plataforma de Gestión</title>

    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Theme Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/estilo.css') }}">

    <style>
        body {
            background-color: #f8fafc;
            /* Color muy limpio para fondo */
            font-family: 'Inter', sans-serif;
        }

        /* Hero Navy Section */
        .hero-section {
            background: linear-gradient(170deg, rgba(15, 23, 42, 0.98) 0%, rgba(30, 41, 59, 1) 100%);
            color: white;
            padding: 8rem 0 6rem 0;
            position: relative;
            overflow: hidden;
            border-bottom-left-radius: 4rem;
            border-bottom-right-radius: 4rem;
            box-shadow: 0 20px 40px rgba(15, 23, 42, 0.1);
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: -100px;
            right: -100px;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(96, 165, 250, 0.15) 0%, transparent 70%);
            border-radius: 50%;
        }

        .navbar-custom {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .feature-card {
            background: white;
            border: none;
            border-radius: 1.25rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
            height: 100%;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.06);
        }

        .icon-box {
            width: 60px;
            height: 60px;
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            background: rgba(13, 110, 253, 0.05);
            /* Soft primary tint */
            color: #0d6efd;
            margin-bottom: 1.5rem;
        }

        .footer-custom {
            padding: 4rem 0 2rem;
            background: white;
            margin-top: 4rem;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
        }
    </style>
</head>

<body>

    <!-- Navegación -->
    <nav class="navbar navbar-expand-lg fixed-top navbar-custom py-3">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2 fw-bold text-dark" href="#">
                <i class="bi bi-heptagon-fill text-primary" style="font-size: 1.5rem;"></i>
                <span style="letter-spacing: -0.02em;">App Web</span>
            </a>

            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse"
                data-bs-target="#navCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navCollapse">
                <ul class="navbar-nav ms-auto align-items-center gap-3 mt-3 mt-lg-0">
                    @auth
                        <li class="nav-item">
                            <a href="{{ url('/dashboard') }}"
                                class="btn btn-primary-theme fw-medium px-4 py-2 rounded-pill shadow-sm">
                                Ir al Dashboard <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a href="{{ route('login') }}" class="btn btn-light fw-medium px-4 py-2 rounded-pill border">
                                Ingresar
                            </a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a href="{{ route('register') }}"
                                    class="btn btn-primary-theme fw-medium px-4 py-2 rounded-pill shadow-sm">
                                    Comenzar Gratis
                                </a>
                            </li>
                        @endif
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Super Hero Section -->
    <header class="hero-section text-center text-md-start">
        <div class="container">
            <div class="row align-items-center justify-content-between g-5">
                <div class="col-lg-6" style="z-index: 2;">
                    <span class="badge bg-white text-dark mb-4 py-2 px-3 fw-medium rounded-pill shadow-sm">
                        <i class="bi bi-star-fill text-warning me-1"></i> Plataforma Laravel Premium v1.0
                    </span>
                    <h1 class="display-4 fw-bolder mb-4" style="line-height: 1.15; letter-spacing: -0.03em;">
                        El panel definitivo para
                        <span style="color: #60a5fa;">gestionar</span> tu corporación.
                    </h1>
                    <p class="lead text-white-50 mb-5" style="font-weight: 300;">
                        Automatiza y centraliza el inventario, organiza tus categorías con exactitud y accede a reportes
                        en tiempo real.
                        Diseñado para la máxima eficiencia operativa.
                    </p>
                    <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center justify-content-md-start">
                        @auth
                            <a href="{{ url('/dashboard') }}"
                                class="btn btn-primary btn-lg fw-semibold px-4 py-3 rounded-pill shadow"
                                style="background:#60a5fa; border-color:#60a5fa;">
                                Abrir Sistema
                            </a>
                        @else
                            <a href="{{ route('register') }}"
                                class="btn btn-primary btn-lg fw-semibold px-4 py-3 rounded-pill shadow"
                                style="background:#60a5fa; border-color:#60a5fa;">
                                Crear una cuenta
                            </a>
                            <a href="{{ route('login') }}"
                                class="btn btn-outline-light btn-lg fw-medium px-4 py-3 rounded-pill">
                                Iniciar Sesión
                            </a>
                        @endauth
                    </div>
                </div>

                <div class="col-lg-5 d-none d-lg-block position-relative" style="z-index: 2;">
                    <div class="card border-0 rounded-4 shadow-lg overflow-hidden"
                        style="transform: perspective(1000px) rotateY(-8deg) rotateX(5deg); transition: transform 0.3s; background: rgba(255,255,255,0.05); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.1) !important;">
                        <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&q=80&w=800"
                            alt="Dashboard" class="img-fluid" style="opacity: 0.8; mix-blend-mode: luminosity;">
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Características (Features) -->
    <section class="container" style="margin-top: -3rem; position: relative; z-index: 10;">
        <div class="row g-4">
            <!-- Modulo 1 -->
            <div class="col-md-4">
                <div class="card feature-card p-4 p-md-5">
                    <div class="icon-box">
                        <i class="bi bi-box-seam"></i>
                    </div>
                    <h3 class="h5 fw-bold mb-3">Gestión de Inventario</h3>
                    <p class="text-secondary mb-0" style="font-size: 0.95rem;">
                        Control total sobre tus productos, sincronización instantánea y organización limpia sin fisuras
                        estructurales.
                    </p>
                </div>
            </div>
            <!-- Modulo 2 -->
            <div class="col-md-4">
                <div class="card feature-card p-4 p-md-5">
                    <div class="icon-box" style="background: rgba(25, 135, 84, 0.05); color: #198754;">
                        <i class="bi bi-tags"></i>
                    </div>
                    <h3 class="h5 fw-bold mb-3">Categorización</h3>
                    <p class="text-secondary mb-0" style="font-size: 0.95rem;">
                        Familias de productos con estados dinámicos controlados inteligentemente bajo las mejores
                        prácticas ORM.
                    </p>
                </div>
            </div>
            <!-- Modulo 3 -->
            <div class="col-md-4">
                <div class="card feature-card p-4 p-md-5">
                    <div class="icon-box" style="background: rgba(220, 53, 69, 0.05); color: #dc3545;">
                        <i class="bi bi-file-earmark-pdf"></i>
                    </div>
                    <h3 class="h5 fw-bold mb-3">Reportes Instantáneos</h3>
                    <p class="text-secondary mb-0" style="font-size: 0.95rem;">
                        Genera documentos y reportes financieros exactos exportados directamente gracias a tecnología de
                        trazabilidad.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer-custom text-center">
        <div class="container">
            <h4 class="fw-bold mb-3">Sistemas Informáticos - CEFTE 2026</h4>
            <p class="text-secondary mb-4">Construyendo interfaces robustas sobre Laravel.</p>
            <hr class="text-muted opacity-25">
            <p class="text-muted small mt-4 mb-0">&copy; {{ date('Y') }} Todos los derechos reservados. Desarrollado
                para la práctica y excelencia de Software.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>