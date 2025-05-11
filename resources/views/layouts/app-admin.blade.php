<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'VetNet') }}</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .main {
            flex: 1;
            display: flex;
        }
        .sidebar {
            width: 250px;
            background-color: #f8f9fa;
            padding-top: 1rem;
            height: 100vh;
            position: fixed;
        }
        .content {
            margin-left: 250px;
            padding: 1rem;
            width: 100%;
        }
    </style>
</head>
<body>
    <!-- Menú superior -->
    <nav class="navbar navbar-light bg-light shadow-sm px-4">
        <a class="navbar-brand" href="#">🐾 VetNet</a>
        <div class="d-flex">
            <div class="dropdown">
                <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
                    Perfil
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
                    <li><a class="dropdown-item" href="{{ route('veterinary.showProfile') }}">Mi perfil</a></li>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="dropdown-item">Cerrar sesión</button>
                    </form>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contenido principal -->
    <div class="main">
        <!-- Menú lateral -->
        <aside class="sidebar border-end">
            <ul class="nav flex-column">
                <li class="nav-item"><a  href="{{ route('veterinary.dashboard') }}" class="nav-link">Dashboard</a></li>
                 @if(auth()->user()->role == 'Admin')
                    <li class="nav-item"><a  href="{{ route('veterinary.showVeterinaries') }}" class="nav-link">Veterinarios</a></li>
                @endif 
               <li class="nav-item"><a href="{{ route('veterinary.showDates') }}" class="nav-link">Citas</a></li>
                <li class="nav-item"><a href="#" class="nav-link">Facturación</a></li>
            </ul>
        </aside>

        <!-- Contenido dinámico -->
        <div class="content">
            @yield('content')
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</body>
</html>