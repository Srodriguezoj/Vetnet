@extends('layouts.app-admin')

@section('content')
    <div class="container-fluid px-3">
        <h1 class="mb-4 text-uppercase fw-bold" style="color: #eb6566;">Veterinarios</h1>
        @if (session('success'))
            <div class="alert alert-success rounded">
                {{ session('success') }}
            </div>
        @endif
        @if ($veterinaries->isEmpty())
            <div class="alert alert-info">
                Aún no hay veterinarios registrados.
            </div>
            <a href="{{ route('veterinary.create') }}" class="btn btn-primary mt-2">Registrar nuevo veterinario</a>
        @else
            <div class="table-responsive">
                <table class="table table-bordered align-middle text-center shadow-sm rounded" style="background-color: #ffffff;">
                    <thead class="text-uppercase" style="background-color:#f4a48f; color:#2e2e2e">
                        <tr>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Nº Colegiado</th>
                            <th>Especialidad</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($veterinaries as $veterinary)
                            <tr>
                                <td>{{ $veterinary->user->name }}</td>
                                <td>{{ $veterinary->user->email }}</td>
                                <td>{{ $veterinary->collegiate_num }}</td>
                                <td>{{ $veterinary->specialty }}</td>
                                <td>
                                    <form action="{{ route('veterinary.delete', $veterinary->id) }}" method="POST" onsubmit="return confirm('¿Eliminar veterinario?');" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <br/>
            <a href="{{ route('veterinary.create') }}" class="btn btn-primary mb-3">Registrar nuevo veterinario</a>
        @endif
    </div>
@endsection
