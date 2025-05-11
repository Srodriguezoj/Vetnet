@extends('layouts.app-admin')

@section('content')
<div class="container">
    <h2>Crear historial médico para {{ $appointment->pet->name }}</h2>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('medicalRecords.store') }}" method="POST">
        @csrf
        <!-- Campos ocultos con los IDs -->
        <input type="hidden" name="id_pet" value="{{ $appointment->pet->id }}">
        <input type="hidden" name="id_veterinary" value="{{ $appointment->id_veterinary }}">
        <input type="hidden" name="id_appointment" value="{{ $appointment->id }}">

        <!-- Diagnóstico -->
        <div class="mb-3">
            <label for="diagnosis" class="form-label">Diagnóstico</label>
            <textarea class="form-control" name="diagnosis" id="diagnosis" rows="4" required></textarea>
        </div>

        <!-- Opcional: recetas y facturas -->
        <div class="mb-3">
            <label for="prescription_name" class="form-label">Prescripción seleccionada</label>
            <input type="text" class="form-control" id="prescription_name" readonly>
        </div>
        <input type="hidden" name="id_prescription" id="id_prescription">
        <!-- Botón para abrir el modal -->
        <button type="button" class="btn btn-secondary mb-3" data-bs-toggle="modal" data-bs-target="#prescriptionModal">
            Añadir prescripción
        </button>
        
        <div class="mb-3">
            <label for="id_invoice" class="form-label">ID Factura (opcional)</label>
            <input type="number" class="form-control" name="id_invoice" id="id_invoice">
        </div>

        <button type="submit" class="btn btn-primary">Guardar historial</button>
    </form>
</div>



<!-- Input oculto donde se guardará el ID -->
<input type="hidden" name="id_prescription" id="id_prescription">

<!-- Modal de Bootstrap -->
<div class="modal fade" id="prescriptionModal" tabindex="-1" aria-labelledby="prescriptionModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="prescriptionForm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nueva prescripción</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                @csrf
                <div class="mb-3">
                    <label for="medication" class="form-label">Medicamento</label>
                    <input type="text" class="form-control" name="medication" required>
                </div>
                <div class="mb-3">
                    <label for="dosage" class="form-label">Dosis</label>
                    <input type="text" class="form-control" name="dosage" required>
                </div>
                <div class="mb-3">
                    <label for="instructions" class="form-label">Instrucciones</label>
                    <textarea class="form-control" name="instructions" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="duration" class="form-label">Duración</label>
                    <input type="text" class="form-control" name="duration" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Guardar prescripción</button>
            </div>
        </div>
    </form>
  </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const form = document.getElementById('prescriptionForm');
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(form);
            fetch('{{ route('prescriptions.store') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.id) {
                    // Asigna el id al input oculto
                    document.getElementById('id_prescription').value = data.id;

                    // Asigna el nombre del medicamento al input visible
                    document.getElementById('prescription_name').value = data.medication;

                    alert('Prescripción guardada correctamente');
                    const modal = bootstrap.Modal.getInstance(document.getElementById('prescriptionModal'));
                    modal.hide();
                    form.reset();
                }
            })
            .catch(err => {
                console.error('Error al guardar prescripción', err);
            });
        });
    });
</script>
@endsection