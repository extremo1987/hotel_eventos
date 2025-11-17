@extends('layouts.app')

@section('title', 'Editar Cotización')

@section('content')
<div class="max-w-xl mx-auto bg-white rounded-xl shadow border border-gray-200 p-6">

    {{-- Encabezado --}}
    <div class="flex justify-between items-center border-b border-gray-200 pb-4 mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">✏️ Editar Cotización</h2>

        <a href="{{ route('cotizaciones.index') }}"
           class="px-3 py-1.5 rounded-lg bg-gray-100 text-gray-800 hover:bg-gray-200 transition">
           ← Volver
        </a>
    </div>

    {{-- Formulario --}}
    <form action="{{ route('cotizaciones.update', $cotizacion->id) }}" method="POST" class="space-y-5">
        @csrf
        @method('PUT')

        {{-- Cliente --}}
        <div>
            <label for="client_id" class="block text-sm text-gray-700 mb-1">Cliente</label>
            <select id="client_id" name="client_id" required
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-200 focus:border-blue-500 outline-none transition">
                <option value="">Seleccione un cliente...</option>
                @foreach($clientes as $c)
                    <option value="{{ $c->id }}" {{ $cotizacion->client_id == $c->id ? 'selected' : '' }}>
                        {{ $c->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Referencia --}}
        <div>
            <label for="reference" class="block text-sm text-gray-700 mb-1">Referencia</label>
            <input id="reference" type="text" name="reference"
                   value="{{ old('reference', $cotizacion->reference) }}"
                   placeholder="Ej. COT-2025-001"
                   required
                   class="w-full border border-gray-300 rounded-lg px-3 py-2
                          focus:ring-2 focus:ring-blue-200 focus:border-blue-500 outline-none transition">
        </div>

        {{-- Subtotal --}}
        <div>
            <label for="subtotal" class="block text-sm text-gray-700 mb-1">Subtotal (L.)</label>
            <input id="subtotal" type="number" step="0.01" name="subtotal"
                value="{{ old('subtotal', $cotizacion->subtotal) }}"
                required
                class="w-full border border-gray-300 rounded-lg px-3 py-2
                       focus:ring-2 focus:ring-blue-200 focus:border-blue-500 outline-none transition">
        </div>

        {{-- Descuento --}}
        <div>
            <label for="discount" class="block text-sm text-gray-700 mb-1">Descuento (L.)</label>
            <input id="discount" type="number" step="0.01" name="discount"
                value="{{ old('discount', $cotizacion->discount) }}"
                class="w-full border border-gray-300 rounded-lg px-3 py-2
                       focus:ring-2 focus:ring-blue-200 focus:border-blue-500 outline-none transition">
        </div>

        {{-- Impuesto --}}
        <div>
            <label for="tax" class="block text-sm text-gray-700 mb-1">Impuesto (L.)</label>
            <input id="tax" type="number" step="0.01" name="tax"
                value="{{ old('tax', $cotizacion->tax) }}"
                class="w-full border border-gray-300 rounded-lg px-3 py-2
                       focus:ring-2 focus:ring-blue-200 focus:border-blue-500 outline-none transition">
        </div>

        {{-- Total --}}
        <div>
            <label for="total" class="block text-sm text-gray-700 mb-1">Total (L.)</label>
            <input id="total" type="number" step="0.01" name="total"
                value="{{ old('total', $cotizacion->total) }}"
                required
                class="w-full border border-gray-300 rounded-lg px-3 py-2
                       focus:ring-2 focus:ring-blue-200 focus:border-blue-500 outline-none transition">
        </div>

        {{-- Fecha de validez --}}
        <div>
            <label for="valid_until" class="block text-sm text-gray-700 mb-1">Válido hasta</label>
            <input id="valid_until" type="date" name="valid_until"
                value="{{ old('valid_until', \Carbon\Carbon::parse($cotizacion->valid_until)->format('Y-m-d')) }}"
                required
                class="w-full border border-gray-300 rounded-lg px-3 py-2
                       focus:ring-2 focus:ring-blue-200 focus:border-blue-500 outline-none transition">
        </div>

        {{-- Estado --}}
        <div>
            <label for="status" class="block text-sm text-gray-700 mb-1">Estado</label>

            <select id="status" name="status" required
                class="w-full border border-gray-300 rounded-lg px-3 py-2
                       focus:ring-2 focus:ring-blue-200 focus:border-blue-500 outline-none transition">

                <option value="borrador"   {{ $cotizacion->status == 'borrador'   ? 'selected' : '' }}>Borrador</option>
                <option value="enviada"    {{ $cotizacion->status == 'enviada'    ? 'selected' : '' }}>Enviada</option>
                <option value="aceptada"   {{ $cotizacion->status == 'aceptada'   ? 'selected' : '' }}>Aceptada</option>
                <option value="rechazada"  {{ $cotizacion->status == 'rechazada'  ? 'selected' : '' }}>Rechazada</option>
                <option value="vencida"    {{ $cotizacion->status == 'vencida'    ? 'selected' : '' }}>Vencida</option>
            </select>
        </div>

        {{-- Botones --}}
        <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
            <button type="submit"
                class="px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 hover:shadow-sm transition">
                Guardar Cambios
            </button>

            <a href="{{ route('cotizaciones.index') }}"
                class="px-4 py-2 rounded-lg bg-gray-100 text-gray-800 hover:bg-gray-200 transition">
                Cancelar
            </a>
        </div>
    </form>
</div>
@endsection
