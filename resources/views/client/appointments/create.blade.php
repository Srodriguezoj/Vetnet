@extends('layouts.app')

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@section('content')
    <div class="container">
        <h1>Reservar Cita</h1>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <form method="POST" action="{{ route('appointments.store') }}">
            @csrf

            <div class="form-group">
                <label for="specialty">Especialidad</label>
                <select name="specialty" id="specialty" class="form-control">
                    <option value="">Selecciona una especialidad</option>
                    @foreach($specialties as $specialty)
                        <option value="{{ $specialty }}">{{ $specialty }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="id_pet">Seleccionar Mascota</label>
                <select name="id_pet" id="id_pet" class="form-control">
                    @foreach($pets as $pet)
                        <option value="{{ $pet->id }}">{{ $pet->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="date">Fecha</label>
                <input type="date" name="date" id="date" class="form-control">
            </div>

            <div class="form-group">
                <label for="time">Hora</label>
                <select name="time" id="time" class="form-control time-select"></select>
            </div>

            <div class="form-group">
                <label for="id_veterinary">Veterinario disponible</label>
                <select name="id_veterinary" id="id_veterinary" class="form-control">
                    <option value="">Selecciona un veterinario</option>
                </select>
            </div>

            <div class="form-group">
                <label for="title">Título</label>
                <input type="text" name="title" id="title" class="form-control">
            </div>

            <div class="form-group">
                <label for="description">Descripción</label>
                <textarea name="description" id="description" class="form-control"></textarea>
            </div>
            <br/>
            <button type="submit" class="btn btn-primary">Reservar Cita</button>
        </form>
    </div>

   

   <script>
    function updateAvailableTimes() {
        const date = document.getElementById('date').value;
        const timeSelect = document.getElementById('time');
        const selectedDate = new Date(date);
        const dayOfWeek = selectedDate.getDay();

        timeSelect.innerHTML = '';
        if (dayOfWeek === 0) {
            alert('No se pueden reservar citas en domingo.');
            return;
        }

        let availableTimes = [];
        if (dayOfWeek === 6) {
            availableTimes = generateAvailableTimes('10:00', '14:00');
        } else {
            availableTimes = generateAvailableTimes('10:00', '14:00').concat(generateAvailableTimes('16:00', '20:00'));
        }
        availableTimes.forEach(time => {
            const option = document.createElement('option');
            option.value = time;
            option.textContent = time;
            timeSelect.appendChild(option);
        });
    }
    function generateAvailableTimes(startTime, endTime) {
        const availableTimes = [];
        const start = toMinutes(startTime);
        const end = toMinutes(endTime);

        for (let minutes = start; minutes < end; minutes += 30) {
            availableTimes.push(toTimeString(minutes));
        }
        return availableTimes;
    }

    function toMinutes(time) {
        const [hour, minute] = time.split(':').map(num => parseInt(num, 10));
        return hour * 60 + minute;
    }

    function toTimeString(minutes) {
        const hour = Math.floor(minutes / 60);
        const minute = minutes % 60;
        return `${hour.toString().padStart(2, '0')}:${minute.toString().padStart(2, '0')}`;
    }
    document.getElementById('date').addEventListener('change', updateAvailableTimes);
    window.addEventListener('load', updateAvailableTimes);
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
                if (error.response) {
                    alert('Error del servidor: ' + error.response.status + ' - ' + error.response.statusText);
                } else {
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
