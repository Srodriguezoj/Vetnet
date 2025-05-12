@extends('layouts.app-admin')

@section('content')
<div class="container">
    <h2>Crear historial médico para {{ $appointment->pet->name }}</h2>

   @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{ route('medicalRecords.store') }}" method="POST">
        @csrf
        <!-- IDs ocultos -->
        <input type="hidden" name="id_client" value="{{ $appointment->pet->id_owner }}">
        <input type="hidden" name="id_pet" value="{{ $appointment->pet->id }}">
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
            <div class="form-group">
                <label for="prescription_medication">Medicamento:</label>
                <span id="prescription_medication" class="form-control">Información de medicamento</span>
            </div>
            <div class="form-group">
                <label for="prescription_dosage">Dosificación:</label>
                <span id="prescription_dosage" class="form-control">Información de dosificación</span>
            </div>
            <div class="form-group">
                <label for="prescription_instructions">Instrucciones:</label>
                <span id="prescription_instructions" class="form-control">Instrucciones del tratamiento</span>
            </div>
            <div class="form-group">
                <label for="prescription_duration">Duración:</label>
                <span id="prescription_duration" class="form-control">Duración del tratamiento</span>
            </div>
        </div>
        <input type="hidden" name="id_prescription" id="id_prescription">
        <button type="button" class="btn btn-secondary mb-3" data-bs-toggle="modal" data-bs-target="#prescriptionModal">
            Añadir prescripción
        </button>

        <!-- Vacuna -->
        <div class="mb-3">
            <label for="vaccine_name" class="form-label">Prescripción Vacuna</label>
            <div class="form-group">
                <label for="vacuna_tipo_de_vacuna">Tipo de vacuna:</label>
                <span id="vacuna_tipo_de_vacuna" class="form-control">Información de tipo de vacuna</span>
            </div>
            <div class="form-group">
                <label for="vacuna_etiqueta">Etiqueta:</label>
                <span id="vacuna_etiqueta" class="form-control">Información de etiqueta</span>
            </div>
            <div class="form-group">
                <label for="vacuna_num_lote">Número de lote:</label>
                <span id="vacuna_num_lote" class="form-control">Información de número de lote</span>
            </div>
            <div class="form-group">
                <label for="vacuna_num_expedicion">Número de expedición:</label>
                <span id="vacuna_num_expedicion" class="form-control">Información del número de expedición</span>
            </div>
        </div>
        <input type="hidden" name="id_vaccine" id="id_vaccine">
        <button type="button" class="btn btn-secondary mb-3" data-bs-toggle="modal" data-bs-target="#vaccineModal">
            Añadir vacuna
        </button>

        <!-- Factura -->
        <div class="mb-3">
            <label for="invoice_name" class="form-label">Factura seleccionada</label>
                
            <div class="mb-3">
                <div class="form-group">
                    <label for="invoice_num">Número de la factura:</label>
                    <span id="invoice_num" class="form-control">Número de la factura</span>
                </div>
                <div class="form-group">
                    <label for="invoice_total">Total:</label>
                    <span id="invoice_total" class="form-control">Total de la factura</span>
                </div>
                <div class="form-group">
                    <label for="invoice_iva">IVA:</label>
                    <span id="invoice_iva" class="form-control">Porcentaje IVA</span>
                </div>
                <div class="form-group">
                    <label for="invoice_total_iva">Total con IVA:</label>
                    <span id="invoice_total_iva" class="form-control">Total con IVA</span>
                </div>
            </div>

            <div id="invoiceSaveItems"></div>

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

<!-- Modal Vacuna -->
<div class="modal fade" id="vaccineModal" tabindex="-1" aria-labelledby="vaccineModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="vaccineForm">
        <input type="hidden" name="id_pet" value="{{ $appointment->pet->id }}">

        @csrf
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nueva vacuna</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="vaccine_type" class="form-label">Tipo de vacuna</label>
                    <input type="text" class="form-control" name="vaccine_type" required>
                </div>
                <div class="mb-3">
                    <label for="stamp" class="form-label">Etiqueta</label>
                    <input type="text" class="form-control" name="stamp" required>
                </div>
                <div class="mb-3">
                    <label for="batch_num" class="form-label">Número de lote</label>
                    <textarea class="form-control" name="batch_num" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="expedition_number" class="form-label">Número de expedición</label>
                    <input type="text" class="form-control" name="expedition_number" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Guardar vacuna</button>
            </div>
        </div>
    </form>
  </div>
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
                    document.getElementById('id_prescription').innerText = data.id;
                    document.getElementById('prescription_medication').innerText = data.medication;
                    document.getElementById('prescription_dosage').innerText = data.dosage;
                    document.getElementById('prescription_instructions').innerText = data.instructions;
                    document.getElementById('prescription_duration').innerText = data.duration;
                    const modal = bootstrap.Modal.getInstance(document.getElementById('prescriptionModal'));
                    modal.hide();
                    prescriptionForm.reset();
                } else {
                    alert('Error al guardar prescripción');
                }
            })
            .catch(err => console.error('Error al guardar prescripción', err));
        });

        const vaccineForm = document.getElementById('vaccineForm');
        vaccineForm.addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(vaccineForm);
            fetch('{{ route('vaccine.store') }}', {
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
                    document.getElementById('id_vaccine').value = data.id;
                    document.getElementById('vacuna_tipo_de_vacuna').innerText = data.vaccine_type;
                    document.getElementById('vacuna_etiqueta').innerText = data.stamp;
                    document.getElementById('vacuna_num_lote').innerText = data.batch_num;
                    document.getElementById('vacuna_num_expedicion').innerText = data.expedition_number;
                    const modal = bootstrap.Modal.getInstance(document.getElementById('vaccineModal'));
                    modal.hide();
                    vaccineForm.reset();
                } else {
                    alert('Error al guardar la vacuna');
                }
            })
            .catch(err => console.error('Error al guardar la vacuna', err));
        });

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
                // Asignar valores de la factura
                document.getElementById('id_invoice').value = data.id;
                document.getElementById('invoice_num').innerText = data.id;
                document.getElementById('invoice_total').innerText = data.total;
                document.getElementById('invoice_iva').innerText = data.tax_percentage;
                document.getElementById('invoice_total_iva').innerText = data.total_with_tax;

                // Mostrar los ítems de la factura
                if (data.items && data.items.length > 0) {
                    const invoiceSaveItems = document.getElementById('invoiceSaveItems'); 
                    invoiceSaveItems.innerHTML = ''; // Limpiar los ítems previos

                    // Recorrer los ítems de la factura
                    data.items.forEach(item => {
                        const itemElement = document.createElement('div');
                        itemElement.classList.add('invoice-item');
                        itemElement.innerHTML = `
                            <div class="form-group">
                                <label for="invoice_item_title">Nombre:</label>
                                <span id="invoice_item_title" class="form-control">${item.title}</span>
                            </div>
                            <div class="form-group">
                                <label for="invoice_item_quantity">Cantidad:</label>
                                <span id="invoice_item_quantity" class="form-control">${item.quantity}</span>
                            </div>
                            <div class="form-group">
                                <label for="invoice_item_price">Precio unitario:</label>
                                <span id="invoice_item_price" class="form-control">${item.unit_price}</span>
                            </div>
                            <div class="form-group">
                                <label for="invoice_item_subtotal">Subtotal:</label>
                                <span id="invoice_item_subtotal" class="form-control">${item.subtotal}</span>
                            </div>
                        `;
                        // Añadir el itemElement al contenedor
                        invoiceSaveItems.appendChild(itemElement);
                    });
                }

                const modal = bootstrap.Modal.getInstance(document.getElementById('invoiceModal'));
                modal.hide();

                invoiceForm.reset();
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
                const quantityInput = item.querySelector('.quantity');
                const unitPriceInput = item.querySelector('.unit-price');
                const subtotalInput = item.querySelector('.subtotal');

                if (quantityInput && unitPriceInput && subtotalInput) {
                    const quantity = parseFloat(quantityInput.value) || 0;
                    const unitPrice = parseFloat(unitPriceInput.value) || 0;
                    const subtotal = quantity * unitPrice;
                    subtotalInput.value = subtotal.toFixed(2);
                    total += subtotal;
                }
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
