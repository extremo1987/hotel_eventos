@extends('layouts.app')

@section('title', 'Detalles de la Cotización')

@section('content')
<div class="max-w-2xl mx-auto bg-white rounded-xl shadow-md border border-gray-200 p-6">

    {{-- Encabezado --}}
    <div class="flex justify-between items-center border-b border-gray-200 pb-4 mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">🧾 Detalles de la Cotización</h2>

        <a href="{{ route('cotizaciones.index') }}"
           class="px-3 py-1.5 rounded-lg bg-gray-100 text-gray-800 hover:bg-gray-200 transition">
           ← Volver
        </a>
    </div>

    {{-- Información principal --}}
    <div class="grid sm:grid-cols-2 gap-4 text-sm">

        {{-- Cliente --}}
        <div class="p-4 rounded-lg border border-gray-100 shadow-sm hover:shadow transition">
            <div class="text-gray-500 font-medium">Cliente</div>
            <div class="text-gray-900 font-semibold">
                {{ $cotizacion->client->name ?? '—' }}
            </div>
        </div>

        {{-- Referencia --}}
        <div class="p-4 rounded-lg border border-gray-100 shadow-sm hover:shadow transition">
            <div class="text-gray-500 font-medium">Referencia</div>
            <div class="text-gray-900 font-semibold">{{ $cotizacion->reference }}</div>
        </div>

        {{-- Subtotal --}}
        <div class="p-4 rounded-lg border border-gray-100 shadow-sm hover:shadow transition">
            <div class="text-gray-500 font-medium">Subtotal</div>
            <div class="text-gray-900 font-semibold">
                L. {{ number_format($cotizacion->subtotal, 2) }}
            </div>
        </div>

        {{-- Descuento --}}
        <div class="p-4 rounded-lg border border-gray-100 shadow-sm hover:shadow transition">
            <div class="text-gray-500 font-medium">Descuento</div>
            <div class="text-gray-900 font-semibold">
                L. {{ number_format($cotizacion->discount, 2) }}
            </div>
        </div>

        {{-- Impuesto --}}
        <div class="p-4 rounded-lg border border-gray-100 shadow-sm hover:shadow transition">
            <div class="text-gray-500 font-medium">Impuesto</div>
            <div class="text-gray-900 font-semibold">
                L. {{ number_format($cotizacion->tax, 2) }}
            </div>
        </div>

        {{-- Total --}}
        <div class="p-4 rounded-lg border border-gray-100 shadow-sm hover:shadow transition">
            <div class="text-gray-500 font-medium">Total (L.)</div>
            <div class="text-gray-900 font-semibold">
                L. {{ number_format($cotizacion->total, 2) }}
            </div>
        </div>

        {{-- Fecha válida --}}
        <div class="p-4 rounded-lg border border-gray-100 shadow-sm hover:shadow transition">
            <div class="text-gray-500 font-medium">Válido Hasta</div>
            <div class="text-gray-900 font-semibold">
                {{ \Carbon\Carbon::parse($cotizacion->valid_until)->format('d/m/Y') }}
            </div>
        </div>

        {{-- Estado --}}
        @php
            $estado = strtolower(trim($cotizacion->status));

            switch ($estado) {
                case 'aceptada':
                    $label = 'Aceptada';
                    $color = 'bg-green-200 text-green-800';
                    break;

                case 'enviada':
                    $label = 'Enviada';
                    $color = 'bg-blue-200 text-blue-800';
                    break;

                case 'rechazada':
                    $label = 'Rechazada';
                    $color = 'bg-red-200 text-red-800';
                    break;

                case 'vencida':
                    $label = 'Vencida';
                    $color = 'bg-yellow-200 text-yellow-800';
                    break;

                default:
                    $label = 'Borrador';
                    $color = 'bg-gray-200 text-gray-800';
                    break;
            }
        @endphp

        <div class="p-4 rounded-lg border border-gray-100 shadow-sm hover:shadow transition">
            <div class="text-gray-500 font-medium">Estado</div>
            <span class="px-3 py-1 rounded-lg text-xs font-semibold {{ $color }}">
                {{ $label }}
            </span>
        </div>

    </div>

    {{-- Botones --}}
    <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-200">
        <a href="{{ route('cotizaciones.edit', $cotizacion->id) }}"
           class="px-5 py-2.5 rounded-lg bg-blue-600 text-white font-medium
                  hover:bg-blue-700 hover:shadow-md transition">
            Editar
        </a>

        <a href="{{ route('cotizaciones.index') }}"
           class="px-5 py-2.5 rounded-lg bg-gray-100 text-gray-800 font-medium
                  hover:bg-gray-200 transition">
            Volver
        </a>
    </div>

</div>
@endsection
