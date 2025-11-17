@extends('layouts.app')

@section('title', 'Nueva Factura')

@section('content')
<div class="max-w-xl mx-auto bg-white rounded-xl shadow border border-gray-200 p-6">

    {{-- Encabezado --}}
    <div class="flex justify-between items-center border-b border-gray-200 pb-4 mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">🧾 Nueva Factura</h2>

        <a href="{{ route('facturas.index') }}"
           class="px-3 py-1.5 rounded-lg bg-gray-100 text-gray-800 hover:bg-gray-200 transition">
           ← Volver
        </a>
    </div>

    <!-- Formulario -->
    <form action="{{ route('facturas.store') }}" method="POST" class="space-y-5">
        @csrf

        {{-- Cliente --}}
        <div>
            <label class="block text-sm text-gray-700 mb-1">Cliente</label>
            <select name="client_id" required
                class="w-full border border-gray-300 rounded-lg px-3 py-2
                       focus:ring-2 focus:ring-blue-200 focus:border-blue-500 outline-none transition">

                <option value="">Seleccione un cliente…</option>

                @foreach($clientes as $c)
                <option value="{{ $c->id }}">{{ $c->name }}</option>
                @endforeach
            </select>
        </div>

        {{-- Número de factura --}}
        <div>
            <label class="block text-sm text-gray-700 mb-1">Número de Factura</label>
            <input type="text" name="invoice_number" required
                   placeholder="Ej. FAC-2025-001"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2
                          focus:ring-2 focus:ring-blue-200 focus:border-blue-500 outline-none transition">
        </div>

        {{-- Fecha emisión --}}
        <div>
            <label class="block text-sm text-gray-700 mb-1">Fecha de Emisión</label>
            <input type="date" name="issued_at" required
                   class="w-full border border-gray-300 rounded-lg px-3 py-2
                          focus:ring-2 focus:ring-blue-200 focus:border-blue-500 outline-none transition">
        </div>

        {{-- Descuento --}}
        <div>
            <label class="block text-sm text-gray-700 mb-1">Descuento (L.)</label>
            <input type="number" step="0.01" name="discount"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2
                          focus:ring-2 focus:ring-blue-200 focus:border-blue-500 outline-none transition"
                   placeholder="0.00">
        </div>

        {{-- Notas --}}
        <div>
            <label class="block text-sm text-gray-700 mb-1">Notas</label>
            <textarea name="notes" rows="3"
                class="w-full border border-gray-300 rounded-lg px-3 py-2
                       focus:ring-2 focus:ring-blue-200 focus:border-blue-500 outline-none transition"
                placeholder="Escriba notas adicionales…"></textarea>
        </div>

        {{-- Ítem inicial (básico) --}}
        <div>
            <label class="block text-sm text-gray-700 mb-2">Primer Ítem</label>

            <div class="space-y-3 border border-gray-200 rounded-xl p-4 bg-gray-50">

                <div>
                    <label class="block text-xs text-gray-600 mb-1">Descripción</label>
                    <input type="text" name="items[0][description]" required
                           placeholder="Ej. Uso del salón"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2">
                </div>

                <div class="grid grid-cols-3 gap-3">
                    <div>
                        <label class="block text-xs text-gray-600 mb-1">Cantidad</label>
                        <input type="number" step="0.01" name="items[0][quantity]" value="1" required
                               class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    </div>

                    <div>
                        <label class="block text-xs text-gray-600 mb-1">Precio</label>
                        <input type="number" step="0.01" name="items[0][unit_price]" required
                               placeholder="0.00"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    </div>

                    <div>
                        <label class="block text-xs text-gray-600 mb-1">ISV</label>
                        <select name="items[0][tax_type]"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2">
                            <option value="exento">Exento</option>
                            <option value="isv15">ISV 15%</option>
                            <option value="isv18">ISV 18%</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        {{-- Botones --}}
        <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
            <button type="submit"
                class="px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 hover:shadow-sm transition">
                Crear Factura
            </button>

            <a href="{{ route('facturas.index') }}"
                class="px-4 py-2 rounded-lg bg-gray-100 text-gray-800 hover:bg-gray-200 transition">
                Cancelar
            </a>
        </div>

    </form>

</div>
@endsection
