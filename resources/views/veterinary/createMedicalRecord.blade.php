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
        <input type="hidden" name="id_client" value="{{ $appointment->pet->id_owner }}">
        <input type="hidden" name="id_veterinary" value="{{ $appointment->id_veterinary }}">
        <input type="hidden" name="id_appointment" value="{{ $appointment->id }}">
        <input type="hidden" name="date" value="{{ now()->toDateString() }}">
        <input type="hidden" name="status" value="Pendiente">

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

<!-- Modal Factura -->
<div class="modal fade" id="invoiceModal" tabindex="-1" aria-labelledby="invoiceModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="invoiceForm">
        <input type="hidden" name="id_client" value="{{ $appointment->pet->id_owner }}">
        <input type="hidden" name="id_veterinary" value="{{ $appointment->id_veterinary }}">
        <input type="hidden" name="id_appointment" value="{{ $appointment->id }}">
        <input type="hidden" name="date" value="{{ now()->toDateString() }}">
        <input type="hidden" name="status" value="Pendiente">

        @csrf
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nueva factura</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <!-- Conceptos -->
                <div id="invoiceItemsContainer">
                    <div class="invoice-item row g-2 mb-2">
                        <div class="col-md-4">
                            <input type="text" name="items[0][title]" class="form-control" placeholder="Concepto" required>
                        </div>
                        <div class="col-md-2">
                            <input type="number" name="items[0][quantity]" class="form-control quantity" placeholder="Cantidad" required>
                        </div>
                        <div class="col-md-2">
                            <input type="number" name="items[0][unit_price]" class="form-control unit-price" placeholder="Precio unit." step="0.01" required>
                        </div>
                        <div class="col-md-2">
                            <input type="number" name="items[0][subtotal]" class="form-control subtotal" readonly placeholder="Subtotal">
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-danger remove-item">X</button>
                        </div>
                    </div>
                </div>
                <button type="button" id="addItemBtn" class="btn btn-secondary mb-3">Añadir ítem</button>

                <!-- Total -->
                <div class="mb-3">
                    <label for="total" class="form-label">Total</label>
                    <input type="number" id="total" name="total" class="form-control" readonly>
                </div>

                <!-- IVA -->
                <div class="mb-3">
                    <label for="tax_percentage" class="form-label">IVA (%)</label>
                    <input type="number" id="tax_percentage" name="tax_percentage" class="form-control" step="0.01">
                </div>

                <!-- Total con IVA -->
                <div class="mb-3">
                    <label for="total_with_tax" class="form-label">Total con IVA</label>
                    <input type="number" id="total_with_tax" name="total_with_tax" class="form-control" readonly>
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
        const invoiceForm = document.getElementById('invoiceForm');
        const invoiceItemsContainer = document.getElementById('invoiceItemsContainer');
        const addItemBtn = document.getElementById('addItemBtn');
        const taxInput = document.getElementById('tax_percentage');
        const totalInput = document.getElementById('total');
        const totalWithTaxInput = document.getElementById('total_with_tax');

        // Manejador de envío del formulario
        invoiceForm.addEventListener('submit', function (e) {
            e.preventDefault();

            // Recoger los ítems de la factura
            const items = [];
            document.querySelectorAll('.invoice-item').forEach(item => {
                const title = item.querySelector('input[name^="items"][name$="[title]"]').value;
                const quantity = parseFloat(item.querySelector('input[name^="items"][name$="[quantity]"]').value) || 0;
                const unitPrice = parseFloat(item.querySelector('input[name^="items"][name$="[unit_price]"]').value) || 0;
                const subtotal = parseFloat(item.querySelector('input[name^="items"][name$="[subtotal]"]').value) || 0;

                items.push({
                    title,
                    quantity,
                    unit_price: unitPrice,
                    subtotal
                });
            });

            // Recoger datos del formulario
            const formData = new FormData(invoiceForm);
            formData.append('items', JSON.stringify(items));
            formData.append('total', totalInput.value);
            formData.append('tax_percentage', taxInput.value);
            formData.append('total_with_tax', totalWithTaxInput.value);

            // Realizar la solicitud
            fetch('{{ route('invoices.store') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(async res => {
                const contentType = res.headers.get('content-type');

                if (!res.ok) {
                    let errorMsg = 'Error al guardar factura';
                    if (contentType && contentType.includes('application/json')) {
                        const errorData = await res.json();
                        errorMsg = errorData.message || errorMsg;
                    }
                    throw new Error(errorMsg);
                }

                if (contentType && contentType.includes('application/json')) {
                    return res.json();
                } else {
                    throw new Error('Respuesta no válida del servidor');
                }
            })
            .then(data => {
                if (data.id) {
                    document.getElementById('id_invoice').value = data.id;
                    document.getElementById('invoice_name').value = data.invoice_number;
                    alert('Factura guardada correctamente');
                    const modal = bootstrap.Modal.getInstance(document.getElementById('invoiceModal'));
                    modal.hide();
                    invoiceForm.reset();
                    invoiceItemsContainer.innerHTML = '';
                    calculateInvoiceTotals(); // Limpiar totales
                } else {
                    alert('Error al guardar factura');
                }
            })
            .catch(err => {
                console.error(err);
                alert(err.message || 'Error inesperado');
            });
        });

        // Agregar ítem a la factura
        addItemBtn.addEventListener('click', () => {
            const index = document.querySelectorAll('.invoice-item').length;
            const newItem = document.createElement('div');
            newItem.classList.add('invoice-item', 'row', 'g-2', 'mb-2');
            newItem.innerHTML = `
                <div class="col-md-4">
                    <input type="text" name="items[${index}][title]" class="form-control" placeholder="Concepto" required>
                </div>
                <div class="col-md-2">
                    <input type="number" name="items[${index}][quantity]" class="form-control quantity" placeholder="Cantidad" required>
                </div>
                <div class="col-md-2">
                    <input type="number" name="items[${index}][unit_price]" class="form-control unit-price" placeholder="Precio unit." step="0.01" required>
                </div>
                <div class="col-md-2">
                    <input type="number" name="items[${index}][subtotal]" class="form-control subtotal" readonly placeholder="Subtotal">
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger remove-item">X</button>
                </div>
            `;
            invoiceItemsContainer.appendChild(newItem);
            calculateInvoiceTotals();
        });

        // Calcular totales al cambiar cantidad o precio
        invoiceItemsContainer.addEventListener('input', (e) => {
            if (e.target.classList.contains('quantity') || e.target.classList.contains('unit-price')) {
                calculateInvoiceTotals();
            }
        });

        // Eliminar ítem
        invoiceItemsContainer.addEventListener('click', (e) => {
            if (e.target.classList.contains('remove-item')) {
                e.target.closest('.invoice-item').remove();
                calculateInvoiceTotals();
            }
        });

        // Calcular totales
        function calculateInvoiceTotals() {
            let total = 0;
            const taxPercentage = parseFloat(taxInput.value) || 0;

            document.querySelectorAll('.invoice-item').forEach(item => {
                const quantity = parseFloat(item.querySelector('.quantity').value) || 0;
                const unitPrice = parseFloat(item.querySelector('.unit-price').value) || 0;
                const subtotal = quantity * unitPrice;
                item.querySelector('.subtotal').value = subtotal.toFixed(2);
                total += subtotal;
            });

            const totalWithTax = total + (total * taxPercentage / 100);
            totalInput.value = total.toFixed(2);
            totalWithTaxInput.value = totalWithTax.toFixed(2);
        }

        // Recalcular totales si se modifica el porcentaje de IVA
        taxInput.addEventListener('input', calculateInvoiceTotals);
    });
</script>
@endsection
