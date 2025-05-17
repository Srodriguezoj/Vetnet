@extends('layouts.app')

@section('content')
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
<div class="container">
    <div class="row">
        <div class="col-md-4 d-flex align-items-center">
            @php
                $speciesImages = [
                    'Perro' => 'perro.jpg',
                    'Gato' => 'gato.jpg',
                    'Huron' => 'huron.jpg'
                ];
                $imagePath = $speciesImages[$pet->species] ?? 'default.jpg';
            @endphp
            <div class="text-center">
                <img src="{{ asset('images/'. $imagePath) }}" class="card-img-top mb-3" style="height: 300px; width: 100%;">
                <h3>{{ $pet->name }}</h3>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Información básica: </h5>
                    <br/>
                    <p><b>Nombre:</b> {{ $pet->name }}</p>
                    <p><b>Microchip:</b> {{ $pet->num_microchip }}</p>
                    <p><b>Especie:</b> {{ $pet->species }}</p>
                    <p><b>Raza:</b> {{ $pet->breed }}</p>
                    <p><b>Color:</b> {{ $pet->colour }}</p>
                    <p><b>Pelo:</b> {{ $pet->coat }}</p>
                    <p><b>Tamaño:</b> {{ $pet->size }}</p>
                    <p><b>Peso:</b> {{ number_format($pet->weight, 2) }} kg</p>
                    <p><b>Sexo:</b> {{ $pet->sex }}</p>
                    <p><b>Fecha de nacimiento:</b> {{ $pet->date_of_birth ? \Carbon\Carbon::parse($pet->date_of_birth)->format('d/m/Y') : 'No disponible' }}</p>
                    <p><b>Edad:</b> {{ $pet->date_of_birth ? \Carbon\Carbon::parse($pet->date_of_birth)->age . ' años' : 'No disponible' }}</p>
                    <div class="mt-3"><a href="{{ route('pets.editPet', ['pet' => $pet->id]) }}" class="btn btn-primary ">Editar mascota</a></div>
                    <div class="mt-2"><button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#vaccinesModal">Vacunas</button></div>
                    <div class="mt-2">
                        @if ($pet->medicalRecords->isNotEmpty())
                        <a href="{{ route('client.showMedicalRecords', $pet->id) }}" class="btn btn-tertiary">Consultar historia clínica</a>
                        @else
                            <p>No hay registros médicos para esta mascota.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Citas -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Citas reservadas: </h5>
                        @if ($pet->appointments->isEmpty())
                        <p>No hay citas registradas para esta mascota.</p>
                        @else
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Hora</th>
                                    <th>Motivo</th>
                                    <th>Veterinario</th>
                                    <th>Estado</th> 
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($pet->appointments as $appointment)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($appointment->date)->format('d/m/Y') }}</td>
                                <td>{{ $appointment->time }}</td>
                                <td>{{ $appointment->title }}</td>
                                <td>{{ $appointment->veterinary->user->name }}</td>
                                <td>{{ $appointment->state }}</td>
                                <td>
                                    @if ($appointment->state == 'Pendiente' || $appointment->state == 'Confirmada')
                                        <form action="{{ route('appointments.destroy', $appointment->id) }}" method="POST" onsubmit="return confirm('¿Quieres cancelar la cita?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Cancelar</button>
                                        </form>
                                    @elseif ($appointment->state == 'Completada')
                                    @endif
                                </td>
                            </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @endif
                    <a href="{{ route('appointments.create') }}" class="btn btn-tertiary mt-3">Nueva cita</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Info vacunas -->
<div class="modal fade" id="vaccinesModal" tabindex="-1" aria-labelledby="vaccinesModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content shadow-sm rounded">
      <div class="modal-header" style="background-color:#eb6566; color: white;">
        <h5 class="text-uppercase" id="vaccinesModalLabel" style="color: #2e2e2e;">Vacunas de {{ $pet->name }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        @if ($pet->vaccinations && $pet->vaccinations->isNotEmpty())
        <div class="table-responsive">
          <table class="table table-bordered align-middle text-center shadow-sm rounded" style="background-color: #fdfafa;">
              <thead style="background-color:#f4a48f; color:#2e2e2e" class="text-uppercase">
                  <tr>
                      <th>Tipo de vacuna</th>
                      <th>Etiqueta</th>
                      <th>Número de lote</th>
                      <th>Número de expedición</th>
                      <th>Fecha de administración</th>
                  </tr>
              </thead>
              <tbody>
                  @foreach ($pet->vaccinations as $vaccination)
                  <tr>
                      <td>{{ $vaccination->vaccine->vaccine_type }}</td>
                      <td>{{ $vaccination->vaccine->stamp }}</td>
                      <td>{{ $vaccination->vaccine->batch_num }}</td>
                      <td>{{ $vaccination->vaccine->expedition_number }}</td>
                      <td>{{ \Carbon\Carbon::parse($vaccination->date_administered)->format('d/m/Y') }}</td>
                  </tr>
                  @endforeach
              </tbody>
          </table>
        </div>
        @else
        <p class="subtitleText">No se han administrado vacunas a esta mascota.</p>
        @endif
      </div>
    </div>
  </div>
</div>

@endsection
