@extends('layouts.app')

@section('title', 'Crear Factura')

@section('content')
<div class="max-w-3xl mx-auto bg-white rounded-xl shadow-md border border-gray-200 p-6">

    {{-- ENCABEZADO --}}
    <div class="flex justify-between items-center border-b border-gray-200 pb-4 mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">🧾 Crear Nueva Factura</h2>

        <a href="{{ route('facturas.index') }}"
           class="px-3 py-1.5 rounded-lg bg-gray-100 text-gray-800 hover:bg-gray-200 transition">
            ← Volver
        </a>
    </div>

    {{-- FORMULARIO --}}
    <form action="{{ route('facturas.store') }}" method="POST" class="space-y-6">
        @csrf

        {{-- DATOS PRINCIPALES --}}
        <div class="grid sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm text-gray-700 mb-1">Cliente</label>
                <select name="client_id" required
                    class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    <option value="">Seleccione...</option>
                    @foreach($clientes as $c)
                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm text-gray-700 mb-1">Número de Factura</label>
                <input type="text" name="invoice_number" required
                    value="{{ old('invoice_number') }}"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2">
            </div>

            <div>
                <label class="block text-sm text-gray-700 mb-1">Fecha de Emisión</label>
                <input type="date" name="issued_at" required
                       value="{{ old('issued_at', date('Y-m-d')) }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2">
            </div>

            <div>
                <label class="block text-sm text-gray-700 mb-1">Estado</label>
                <select name="status" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    <option value="emitida">Emitida</option>
                    <option value="pagada">Pagada</option>
                    <option value="anulada">Anulada</option>
                </select>
            </div>
        </div>

        {{-- NOTAS --}}
        <div>
            <label class="block text-sm text-gray-700 mb-1">Notas</label>
            <textarea name="notes" rows="3"
                class="w-full border border-gray-300 rounded-lg px-3 py-2">{{ old('notes') }}</textarea>
        </div>

        {{-- ÍTEMS --}}
        <div class="border-t border-gray-200 pt-4">
            <h3 class="text-lg font-semibold mb-3">Ítems de Factura</h3>

            <table class="w-full text-sm border border-gray-300 rounded-lg overflow-hidden">
                <thead style="background:#2563eb;color:white;">
                    <tr>
                        <th class="px-3 py-2">Descripción</th>
                        <th class="px-3 py-2">Cant.</th>
                        <th class="px-3 py-2">Precio</th>
                        <th class="px-3 py-2">ISV</th>
                        <th class="px-3 py-2">Acciones</th>
                    </tr>
                </thead>
                <tbody id="itemsTable">
                    {{-- Primera fila por defecto --}}
                    <tr class="border-b">
                        <td class="px-3 py-2"><input type="text" name="items[0][description]" class="w-full border-gray-300 rounded-lg item-desc"></td>
                        <td class="px-3 py-2"><input type="number" step="0.01" name="items[0][quantity]" class="w-full border-gray-300 rounded-lg item-qty"></td>
                        <td class="px-3 py-2"><input type="number" step="0.01" name="items[0][unit_price]" class="w-full border-gray-300 rounded-lg item-price"></td>
                        <td class="px-3 py-2">
                            <select name="items[0][tax_type]" class="w-full border-gray-300 rounded-lg item-tax">
                                <option value="exento">Exento</option>
                                <option value="isv15">ISV 15%</option>
                                <option value="isv18">ISV 18%</option>
                            </select>
                        </td>
                        <td class="px-3 py-2 text-center">
                            <button type="button" class="text-red-600 font-semibold removeItem">✖</button>
                        </td>
                    </tr>
                </tbody>
            </table>

            <button type="button" id="addItem" class="mt-3 px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700">
                ➕ Agregar Ítem
            </button>
        </div>

        {{-- TOTALES --}}
        <div class="grid sm:grid-cols-2 gap-4 border-t border-gray-200 pt-4">
            <div class="p-4 bg-gray-50 rounded-lg border text-sm space-y-1">
                <div class="flex justify-between">
                    <span class="text-gray-600">Subtotal</span>
                    <span id="subtotalLabel" class="font-semibold">L. 0.00</span>
                </div>

                <div class="flex justify-between">
                    <span class="text-gray-600">Descuento</span>
                    <input id="discountInput" type="number" step="0.01" name="discount"
                        value="{{ old('discount',0) }}"
                        class="border border-gray-300 rounded px-2 py-1 w-24 text-right">
                </div>

                <div class="flex justify-between"><span class="text-gray-600">ISV 15%</span><span id="isv15Label" class="font-semibold">L. 0.00</span></div>
                <div class="flex justify-between"><span class="text-gray-600">ISV 18%</span><span id="isv18Label" class="font-semibold">L. 0.00</span></div>
            </div>

            <div class="p-4 bg-blue-50 rounded-lg border">
                <div class="text-sm text-gray-600">Total a Cobrar</div>
                <input id="grandTotal" type="text"
                       value="0.00"
                       class="mt-1 w-full border border-blue-200 rounded-lg px-3 py-2 bg-blue-100 font-semibold text-blue-900"
                       readonly>
                <small class="text-xs text-blue-700">Este total se usa para calcular el vuelto.</small>
            </div>
        </div>

        {{-- PAGO --}}
        <div class="grid sm:grid-cols-3 gap-4 pt-4 border-t border-gray-200">
            <div>
                <label class="block text-sm text-gray-700 mb-1">Monto Pagado</label>
                <input type="number" id="paymentAmount" name="payment_amount"
                       value="{{ old('payment_amount') }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2">
                <span id="pagoHint" class="text-xs"></span>
            </div>

            <div>
                <label class="block text-sm text-gray-700 mb-1">Método</label>
                <select name="payment_method" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    <option value="">Seleccione...</option>
                    <option value="efectivo">Efectivo</option>
                    <option value="tarjeta">Tarjeta</option>
                    <option value="transferencia">Transferencia</option>
                </select>
            </div>

            <div>
                <label class="block text-sm text-gray-700 mb-1">Vuelto</label>
                <input type="text" id="changeAmount" name="change_amount"
                       value="{{ old('change_amount',0) }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-gray-100" readonly>
            </div>
        </div>

        {{-- BOTONES --}}
        <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
            <button type="submit" class="px-5 py-2.5 rounded-lg bg-green-600 text-white hover:bg-green-700">
                Crear Factura
            </button>
            <a href="{{ route('facturas.index') }}" class="px-5 py-2.5 rounded-lg bg-gray-100 text-gray-800 hover:bg-gray-200">
                Cancelar
            </a>
        </div>
    </form>
</div>

{{-- SCRIPT: CÁLCULOS --}}
<script>
document.addEventListener("DOMContentLoaded", function () {

    const table = document.getElementById('itemsTable');
    const subtotalLabel = document.getElementById('subtotalLabel');
    const isv15Label = document.getElementById('isv15Label');
    const isv18Label = document.getElementById('isv18Label');
    const grandTotal = document.getElementById('grandTotal');
    const discountInput = document.getElementById('discountInput');
    const inputPago = document.getElementById('paymentAmount');
    const inputCambio = document.getElementById('changeAmount');
    const hint = document.getElementById('pagoHint');

    function formatMoney(num) {
        return (num || 0).toLocaleString("es-HN",{minimumFractionDigits:2,maximumFractionDigits:2});
    }

    function calcularTotales() {
        let subtotal = 0, isv15 = 0, isv18 = 0;

        table.querySelectorAll('tr').forEach(row => {
            const qty = parseFloat(row.querySelector('.item-qty')?.value || 0);
            const price = parseFloat(row.querySelector('.item-price')?.value || 0);
            const tax = row.querySelector('.item-tax')?.value || 'exento';

            const line = qty * price;
            subtotal += line;

            if (tax === 'isv15') isv15 += line * 0.15;
            if (tax === 'isv18') isv18 += line * 0.18;
        });

        const discount = parseFloat(discountInput.value || 0);
        const total = subtotal - discount + isv15 + isv18;

        subtotalLabel.textContent = "L. " + formatMoney(subtotal);
        isv15Label.textContent = "L. " + formatMoney(isv15);
        isv18Label.textContent = "L. " + formatMoney(isv18);
        grandTotal.value = formatMoney(total);

        calcularCambio();
    }

    function calcularCambio() {
        const total = parseFloat(grandTotal.value.replace(/,/g, '')) || 0;
        const pagado = parseFloat((inputPago.value || '').replace(/,/g,'')) || 0;
        const diff = pagado - total;

        if (diff >= 0) {
            inputCambio.value = formatMoney(diff);
            hint.textContent = "Vuelto listo."; hint.className = "text-xs text-green-600";
        } else {
            inputCambio.value = "0.00";
            hint.textContent = "Faltan L. " + formatMoney(Math.abs(diff)); hint.className = "text-xs text-red-600";
        }
    }

    // Eventos
    document.addEventListener('input', e => {
        if (e.target.closest('#itemsTable') || e.target === discountInput) calcularTotales();
    });

    ["input","keyup","change","paste"].forEach(ev => inputPago.addEventListener(ev, calcularCambio));

    // Agregar fila
    document.getElementById('addItem').addEventListener('click', () => {
        const index = table.rows.length;
        const row = `
            <tr class="border-b">
                <td class="px-3 py-2"><input type="text" name="items[${index}][description]" class="w-full border-gray-300 rounded-lg item-desc"></td>
                <td class="px-3 py-2"><input type="number" step="0.01" name="items[${index}][quantity]" class="w-full border-gray-300 rounded-lg item-qty"></td>
                <td class="px-3 py-2"><input type="number" step="0.01" name="items[${index}][unit_price]" class="w-full border-gray-300 rounded-lg item-price"></td>
                <td class="px-3 py-2">
                    <select name="items[${index}][tax_type]" class="w-full border-gray-300 rounded-lg item-tax">
                        <option value="exento">Exento</option>
                        <option value="isv15">ISV 15%</option>
                        <option value="isv18">ISV 18%</option>
                    </select>
                </td>
                <td class="px-3 py-2 text-center">
                    <button type="button" class="text-red-600 font-semibold removeItem">✖</button>
                </td>
            </tr>`;
        table.insertAdjacentHTML('beforeend', row);
    });

    // Eliminar fila
    document.addEventListener('click', e => {
        if (e.target.classList.contains('removeItem')) {
            e.target.closest('tr').remove();
            calcularTotales();
        }
    });

    calcularTotales(); // inicial
});
</script>
@endsection
