@extends('layouts.app')
@php use Illuminate\Support\Facades\Auth; @endphp

@section('content')
@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<h2>Bienvenido, {{ Auth::user()->name }}</h2>
<p>Estás dentro del panel privado.</p>
<a href="{{ route('logout') }}" class="btn btn-danger">Cerrar sesión</a>
@endsection