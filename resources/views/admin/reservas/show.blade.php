@extends('layouts.app')

@section('title', 'Detalles de la Reserva')

@section('content')
<div class="max-w-2xl mx-auto bg-white rounded-xl shadow-md border border-gray-200 p-6">

    {{-- Encabezado --}}
    <div class="flex justify-between items-center border-b border-gray-200 pb-4 mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">📅 Detalles de la Reserva</h2>

        <a href="{{ route('reservas.index') }}"
           class="px-3 py-1.5 rounded-lg bg-gray-100 text-gray-800 hover:bg-gray-200 transition">
           ← Volver
        </a>
    </div>

    {{-- Información principal --}}
    <div class="grid sm:grid-cols-2 gap-4 text-sm">

        {{-- Cliente --}}
        <div class="p-4 rounded-lg border border-gray-100 shadow-sm hover:shadow transition">
            <div class="text-gray-500 font-medium">Cliente</div>
            <div class="text-gray-900 font-semibold">{{ $reserva->client->name ?? '—' }}</div>
        </div>

        {{-- Salón --}}
        <div class="p-4 rounded-lg border border-gray-100 shadow-sm hover:shadow transition">
            <div class="text-gray-500 font-medium">Salón</div>
            <div class="text-gray-900 font-semibold">{{ $reserva->salon->name ?? '—' }}</div>
        </div>

        {{-- Título --}}
        <div class="sm:col-span-2 p-4 rounded-lg border border-gray-100 shadow-sm hover:shadow transition">
            <div class="text-gray-500 font-medium">Título / Evento</div>
            <div class="text-gray-900 font-semibold">{{ $reserva->title ?? '—' }}</div>
        </div>

        {{-- Inicio --}}
        <div class="p-4 rounded-lg border border-gray-100 shadow-sm hover:shadow transition">
            <div class="text-gray-500 font-medium">Inicio</div>
            <div class="text-gray-900 font-semibold">
                {{ \Carbon\Carbon::parse($reserva->start_at)->format('d/m/Y H:i') }}
            </div>
        </div>

        {{-- Final --}}
        <div class="p-4 rounded-lg border border-gray-100 shadow-sm hover:shadow transition">
            <div class="text-gray-500 font-medium">Finalización</div>
            <div class="text-gray-900 font-semibold">
                {{ \Carbon\Carbon::parse($reserva->end_at)->format('d/m/Y H:i') }}
            </div>
        </div>

        {{-- Estado --}}
        @php
            $status = strtolower(trim($reserva->status));

            switch ($status) {
                case 'confirmada':
                    $label = 'Confirmada';
                    $color = 'bg-green-200 text-green-800';
                    break;

                case 'pendiente':
                    $label = 'Pendiente';
                    $color = 'bg-yellow-200 text-yellow-800';
                    break;

                default:
                    $label = 'Cancelada';
                    $color = 'bg-red-200 text-red-800';
                    break;
            }
        @endphp

        <div class="p-4 rounded-lg border border-gray-100 shadow-sm hover:shadow transition">
            <div class="text-gray-500 font-medium">Estado</div>
            <span class="px-3 py-1 rounded-lg text-xs font-semibold {{ $color }}">
                {{ $label }}
            </span>
        </div>

        {{-- Total --}}
        <div class="p-4 rounded-lg border border-gray-100 shadow-sm hover:shadow transition">
            <div class="text-gray-500 font-medium">Total (L.)</div>
            <div class="text-gray-900 font-semibold">
                {{ $reserva->total ? 'L. '.number_format($reserva->total,2) : '—' }}
            </div>
        </div>

        {{-- Notas --}}
        @if($reserva->notes)
            <div class="sm:col-span-2 p-4 rounded-lg border border-gray-100 shadow-sm hover:shadow transition">
                <div class="text-gray-500 font-medium">Notas</div>
                <div class="text-gray-800 whitespace-pre-line">{{ $reserva->notes }}</div>
            </div>
        @endif
    </div>

    {{-- Botones --}}
    <div class="flex flex-wrap justify-end gap-3 mt-6 pt-4 border-t border-gray-200">

        {{-- Botón Editar --}}
        <a href="{{ route('reservas.edit', $reserva->id) }}"
           class="px-5 py-2.5 rounded-lg bg-blue-600 text-white font-medium
                  hover:bg-blue-700 hover:shadow-md transition">
            Editar
        </a>

        {{-- Factura --}}
        @if($reserva->invoice)
            {{-- Si ya tiene factura, mostrar botón para verla --}}
            <a href="{{ route('facturas.show', $reserva->invoice->id) }}"
               class="px-5 py-2.5 rounded-lg bg-green-600 text-white font-medium
                      hover:bg-green-700 hover:shadow-md transition">
                Ver Factura
            </a>
        @else
         
        @endif

        {{-- Volver --}}
        <a href="{{ route('reservas.index') }}"
           class="px-5 py-2.5 rounded-lg bg-gray-100 text-gray-800 font-medium
                  hover:bg-gray-200 transition">
            Volver
        </a>
    </div>
</div>
@endsection
