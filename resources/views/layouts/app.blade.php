<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Vetnet') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/css.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <!-- Menú superior -->
    <nav class="navbar navbar-light bg-light shadow-sm justify-content-between px-3">
        <div class="d-flex align-items-center">
            <a class="navbar-brand me-3" href="{{ route('client.dashboard') }}"><img src="{{ asset('images/logoText.png') }}" style="max-width:50px;" alt="VetNet Logo"></a>
            <a href="{{ route('appointments.create') }}" class="btn btn-primary me-2">Pedir cita</a>
            <a href="#" class="btn btn-tertiary me-2">Contacto</a>
        </div>

        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
                Perfil
            </button>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
                <li><a class="dropdown-item" href="{{ route('client.showClient') }}">Mi perfil</a></li>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="dropdown-item">Cerrar sesión</button>
                </form>
            </ul>
        </div>
    </nav>

    <!-- Contenido principal -->
    <div class="content d-flex justify-content-center align-items-start">
        <div class="container p-4 mt-4 mb-5 shadow rounded bg-white" style="max-width: 1000px;">
            @yield('content')
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>