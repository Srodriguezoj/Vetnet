@extends('layouts.app')

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@section('content')
    <div class="container">
        <h1>Reservar Cita</h1>

        <!-- Meta CSRF para JS -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <form method="POST" action="{{ route('appointments.store') }}">
            @csrf

            <!-- Especialidad -->
            <div class="form-group">
                <label for="specialty">Especialidad</label>
                <select name="specialty" id="specialty" class="form-control">
                    <option value="">Selecciona una especialidad</option>
                    @foreach($specialties as $specialty)
                        <option value="{{ $specialty }}">{{ $specialty }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Mascota -->
            <div class="form-group">
                <label for="id_pet">Seleccionar Mascota</label>
                <select name="id_pet" id="id_pet" class="form-control">
                    @foreach($pets as $pet)
                        <option value="{{ $pet->id }}">{{ $pet->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Fecha y Hora -->
            <div class="form-group">
                <label for="date">Fecha</label>
                <input type="date" name="date" id="date" class="form-control">
            </div>

            <div class="form-group">
                <label for="time">Hora</label>
                <input type="time" name="time" id="time" class="form-control">
            </div>

            <!-- Veterinario -->
            <div class="form-group">
                <label for="id_veterinary">Veterinario disponible</label>
                <select name="id_veterinary" id="id_veterinary" class="form-control">
                    <option value="">Selecciona un veterinario</option>
                    <!-- Se rellenará dinámicamente vía JavaScript -->
                </select>
            </div>

            <!-- Título y Descripción -->
            <div class="form-group">
                <label for="title">Título</label>
                <input type="text" name="title" id="title" class="form-control">
            </div>

            <div class="form-group">
                <label for="description">Descripción</label>
                <textarea name="description" id="description" class="form-control"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Reservar Cita</button>
        </form>
    </div>


   <script>
    function updateVeterinarians() {
        const specialty = document.getElementById('specialty').value;
        const date = document.getElementById('date').value;
        const time = document.getElementById('time').value;

        if (specialty && date && time) {
            if (isNaN(Date.parse(date))) {
                alert('Fecha no válida.');
                return;
            }
            if (!/^\d{2}:\d{2}$/.test(time)) {
                alert('Hora no válida.');
                return;
            }

            fetch('{{ route('appointments.checkAvailability') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ specialty, date, time })
            })
            .then(response => response.json())
            .then(data => {
                const select = document.getElementById('id_veterinary');
                select.innerHTML = '<option value="">Selecciona un veterinario</option>';

                if (data && Array.isArray(data) && data.length > 0) {
                    data.forEach(vet => {
                        let option = document.createElement('option');
                        option.value = vet.id;
                        option.textContent = vet.name;
                        select.appendChild(option);
                    });
                } else {
                    alert('No hay veterinarios disponibles para esa fecha y hora. Por favor, elige otra.');
                }
            })
            .catch(error => {
                console.log("Error en la solicitud AJAX:", error);

                // Mostrar más detalles del error
                if (error.response) {
                    console.log("Respuesta del servidor:", error.response);
                    alert('Error del servidor: ' + error.response.status + ' - ' + error.response.statusText);
                } else {
                    console.log("Error general:", error);
                    alert('Hubo un error al obtener los veterinarios. Por favor, intenta nuevamente.');
                }
            });
        }
    }

    document.getElementById('specialty').addEventListener('change', updateVeterinarians);
    document.getElementById('date').addEventListener('change', updateVeterinarians);
    document.getElementById('time').addEventListener('change', updateVeterinarians);
</script>
@endsection