@extends('layouts.app-admin')

@section('content')
    <div class="container">
        @if(Auth::check() && (Auth::user()->role === 'Admin' || Auth::user()->role === 'Veterinario'))
            <h2>Bienvenido/a, {{ Auth::user()->name }}</h2>
            <p>Este es el panel de administración/veterinarios.</p>

            <a href="{{ route('logout') }}" class="btn btn-danger">Cerrar sesión</a>
        @else
            <h2>No tienes permiso para ver esta página.</h2>
            <a href="{{ url('/') }}" class="btn btn-primary">Volver al inicio</a>
        @endif
    </div>
@endsection