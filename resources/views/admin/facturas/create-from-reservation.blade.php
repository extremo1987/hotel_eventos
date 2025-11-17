@extends('layouts.app')

@section('title', 'Generar Factura')

@section('content')
<div class="max-w-3xl mx-auto bg-white rounded-xl shadow border border-gray-200 p-6">

    {{-- Encabezado --}}
    <div class="flex justify-between items-center border-b border-gray-200 pb-4 mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">🧾 Generar Factura</h2>

        <a href="{{ route('reservas.show', $reserva->id) }}"
           class="px-3 py-1.5 rounded-lg bg-gray-100 text-gray-800 hover:bg-gray-200 transition">
           ← Volver
        </a>
    </div>

    {{-- Datos de la reserva --}}
    <div class="mb-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
        <h3 class="text-lg font-semibold mb-2">Información de la Reserva</h3>

        <p><strong>Cliente:</strong> {{ $reserva->client->name }}</p>
        <p><strong>Salón:</strong> {{ $reserva->salon->name }}</p>
        <p><strong>Evento:</strong> {{ $reserva->title }}</p>
        <p><strong>Total Reserva:</strong> L. {{ number_format($reserva->total, 2) }}</p>
    </div>

    {{-- Formulario --}}
    <form action="{{ route('facturas.store') }}" method="POST" class="space-y-5">
        @csrf

        <input type="hidden" name="reservation_id" value="{{ $reserva->id }}">
        <input type="hidden" name="client_id" value="{{ $reserva->client_id }}">

        {{-- Número de factura --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Número de factura</label>
            <input type="text" name="invoice_number" required
                   value="FAC-{{ date('Y') }}-{{ str_pad($reserva->id, 3, '0', STR_PAD_LEFT) }}"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2
                          focus:ring-2 focus:ring-blue-200 focus:border-blue-500 outline-none transition">
        </div>

        {{-- Fecha --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de emisión</label>
            <input type="date" name="issued_at" required value="{{ date('Y-m-d') }}"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2
                          focus:ring-2 focus:ring-blue-200 focus:border-blue-500 outline-none transition">
        </div>

        {{-- Items automáticos --}}
        <h3 class="font-semibold text-gray-800">Ítems de Factura</h3>

        <div class="border rounded-lg p-4 bg-gray-50">
            <p><strong>Descripción:</strong> Alquiler de salón: {{ $reserva->salon->name }}</p>
            <p><strong>Precio:</strong> L. {{ number_format($reserva->salon->price, 2) }}</p>

            <input type="hidden" name="items[0][description]" value="Alquiler de salón: {{ $reserva->salon->name }}">
            <input type="hidden" name="items[0][quantity]" value="1">
            <input type="hidden" name="items[0][unit_price]" value="{{ $reserva->salon->price }}">
            <input type="hidden" name="items[0][tax_type]" value="isv15">
        </div>

        {{-- Notas --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Notas</label>
            <textarea name="notes" rows="3"
                      class="w-full border border-gray-300 rounded-lg px-3 py-2
                             focus:ring-2 focus:ring-blue-200 focus:border-blue-500 outline-none transition"></textarea>
        </div>

        {{-- Botones --}}
        <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
            <button type="submit"
                class="px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 hover:shadow transition">
                Generar Factura
            </button>
        </div>

    </form>
</div>
@endsection
