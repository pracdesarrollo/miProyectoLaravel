<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistema de Ventas - Inicio</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }
        .hero-section {
            background-color: #0d6efd;
            color: white;
            padding: 8rem 0;
            text-align: center;
        }
        .features-section {
            padding: 4rem 0;
        }
        .feature-card {
            border: none;
            text-align: center;
        }
        .feature-icon {
            font-size: 3rem;
            color: #0d6efd;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="/">
            <i class="bi bi-shop me-2"></i>Sistema de Ventas
        </a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">Registro</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<header class="hero-section">
    <div class="container">
        <h1 class="display-4 fw-bold">Gestión de Ventas Simplificada</h1>
        <p class="lead mt-3 mb-4">
            Optimiza tu negocio y lleva un control total de tus productos, inventario y ventas.
        </p>
        <a href="{{ route('login') }}" class="btn btn-light btn-lg px-4 me-md-2 fw-bold">
            Comenzar Ahora
        </a>
    </div>
</header>

<section class="features-section">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-12">
                <h2 class="display-6 fw-bold">¿Qué hace nuestra aplicación?</h2>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card p-4 feature-card">
                    <div class="card-body">
                        <i class="bi bi-box feature-icon"></i>
                        <h5 class="card-title">Gestión de Productos</h5>
                        <p class="card-text text-muted">
                            Controla tu inventario, precios y stock en tiempo real.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-4 feature-card">
                    <div class="card-body">
                        <i class="bi bi-cart feature-icon"></i>
                        <h5 class="card-title">Registro de Ventas</h5>
                        <p class="card-text text-muted">
                            Registra cada transacción de forma rápida y sencilla.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-4 feature-card">
                    <div class="card-body">
                        <i class="bi bi-people feature-icon"></i>
                        <h5 class="card-title">Control de Usuarios</h5>
                        <p class="card-text text-muted">
                            Gestiona los accesos de administradores y vendedores de tu equipo.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<footer class="py-4 mt-5">
    <div class="container text-center">
        <p class="text-muted mb-0">&copy; {{ date('Y') }} Sistema de Ventas. Todos los derechos reservados.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>