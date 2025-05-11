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
        <!-- IDs ocultos -->
        <input type="hidden" name="id_pet" value="{{ $appointment->pet->id }}">
        <input type="hidden" name="id_veterinary" value="{{ $appointment->id_veterinary }}">
        <input type="hidden" name="id_appointment" value="{{ $appointment->id }}">

        <div class="mb-3">
            <label for="diagnosis" class="form-label">Diagnóstico</label>
            <textarea class="form-control" name="diagnosis" id="diagnosis" rows="4" required></textarea>
        </div>

        <!-- Prescripción -->
        <div class="mb-3">
            <label for="prescription_name" class="form-label">Prescripción seleccionada</label>
            <input type="text" class="form-control" id="prescription_name" readonly>
        </div>
        <input type="hidden" name="id_prescription" id="id_prescription">
        <button type="button" class="btn btn-secondary mb-3" data-bs-toggle="modal" data-bs-target="#prescriptionModal">
            Añadir prescripción
        </button>

        <!-- Factura -->
        <div class="mb-3">
            <label for="invoice_name" class="form-label">Factura seleccionada</label>
            <input type="text" class="form-control" id="invoice_name" readonly>
        </div>
        <input type="hidden" name="id_invoice" id="id_invoice">
        <button type="button" class="btn btn-secondary mb-3" data-bs-toggle="modal" data-bs-target="#invoiceModal">
            Añadir factura
        </button>
        <br/>
        <button type="submit" class="btn btn-primary">Guardar historial</button>
    </form>
</div>

<!-- Modal Prescripción -->
<div class="modal fade" id="prescriptionModal" tabindex="-1" aria-labelledby="prescriptionModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="prescriptionForm">
        @csrf
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nueva prescripción</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
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

<!-- Modal Factura -->
<div class="modal fade" id="invoiceModal" tabindex="-1" aria-labelledby="invoiceModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="invoiceForm">
        @csrf
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nueva factura</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="id_client" class="form-label">ID Cliente</label>
                    <input type="number" class="form-control" name="id_client" required>
                </div>
                <div class="mb-3">
                    <label for="id_veterinary" class="form-label">ID Veterinario</label>
                    <input type="number" class="form-control" name="id_veterinary" required>
                </div>
                <div class="mb-3">
                    <label for="date" class="form-label">Fecha</label>
                    <input type="date" class="form-control" name="date" required>
                </div>
                <div class="mb-3">
                    <label for="total" class="form-label">Total</label>
                    <input type="number" class="form-control" name="total" step="0.01" required>
                </div>
                <div class="mb-3">
                    <label for="tax_percentage" class="form-label">IVA (%)</label>
                    <input type="number" class="form-control" name="tax_percentage" step="0.01" required>
                </div>
                <div class="mb-3">
                    <label for="total_with_tax" class="form-label">Total con IVA</label>
                    <input type="number" class="form-control" name="total_with_tax" step="0.01" required>
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Estado</label>
                    <input type="text" class="form-control" name="status" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Guardar factura</button>
            </div>
        </div>
    </form>
  </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const prescriptionForm = document.getElementById('prescriptionForm');
        prescriptionForm.addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(prescriptionForm);
            fetch('{{ route('prescriptions.store') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.id) {
                    document.getElementById('id_prescription').value = data.id;
                    document.getElementById('prescription_name').value = data.medication;
                    alert('Prescripción guardada correctamente');
                    const modal = bootstrap.Modal.getInstance(document.getElementById('prescriptionModal'));
                    modal.hide();
                    prescriptionForm.reset();
                } else {
                    alert('Error al guardar prescripción');
                }
            })
            .catch(err => console.error('Error al guardar prescripción', err));
        });

        const invoiceForm = document.getElementById('invoiceForm');
        invoiceForm.addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(invoiceForm);
            fetch('{{ route('invoices.store') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.id) {
                    document.getElementById('id_invoice').value = data.id;
                    document.getElementById('invoice_name').value = data.invoice_number;
                    alert('Factura guardada correctamente');
                    const modal = bootstrap.Modal.getInstance(document.getElementById('invoiceModal'));
                    modal.hide();
                    invoiceForm.reset();
                } else {
                    alert('Error al guardar factura');
                }
            })
            .catch(err => console.error('Error al guardar factura', err));
        });
    });
</script>
@endsection
