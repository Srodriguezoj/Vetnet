<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Vetnet') }}</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/css.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
       
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
        .content-wrapper {
            margin-left: 250px;
            padding: 2rem;
            width: 100%;
        }
        .content-box {
            max-width: auto;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 2rem;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            border-radius: 0.5rem;
        }
        .nav-item{
            color: #eb6566 !important;
            padding-left: 10%;
            padding-bottom: 5%;
        }
    </style>

    
</head>
<body>
    <nav class="navbar  shadow-sm justify-content-between px-4">
    <a class="navbar-brand me-3" href="{{ route('veterinary.showDates') }}"><img src="{{ asset('images/logoText.png') }}" style="max-width:50px;" alt="VetNet Logo"></a>
        <div class="d-flex">
            <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle" type="button" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false"> Perfil</button>
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
    
    <div class="main">
        @if(auth()->user()->role == 'Admin')
            <aside class="sidebar border-end">
                <ul class="nav flex-column">
                    <li class="nav-item"><a href="{{ route('veterinary.showVeterinaries') }}">Veterinarios</a></li>
                    <li class="nav-item"><a href="{{ route('veterinary.showAllDates') }}">Citas</a></li>
                    <li class="nav-item"><a href="{{ route('veterinary.showInvoices') }}">Facturas</a></li>
                    <li class="nav-item"><a href="{{ route('veterinary.showPets') }}">Consultar mascotas</a></li>
                </ul>
            </aside>
        @elseif(auth()->user()->role == 'Veterinario')
            <aside class="sidebar border-end">
                <ul class="nav flex-column">
                    <li class="nav-item"><a href="{{ route('veterinary.showDates') }}">Mis citas</a></li>
                    <li class="nav-item"><a href="{{ route('veterinary.showPets') }}">Consultar mascotas</a></li>
                </ul>
            </aside>
        @endif

        <div class="content-wrapper">
            <div class="content-box">
                @yield('content')
            </div>
        </div>
    </div>
   
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</body>
</html>