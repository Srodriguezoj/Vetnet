@extends('layouts.app-admin')

@section('content')
    <div class="container">
        @if(Auth::check() && (Auth::user()->role === 'Admin' || Auth::user()->role === 'Veterinario'))
            <h2>Panel de Administrador</h2>

        @else
            <h2>No tienes permiso para ver esta página.</h2>
            <a href="{{ url('/') }}" class="btn btn-primary">Volver al inicio</a>
        @endif
    </div>
@endsection