@extends('layouts.app')

@section('title', 'Detalle de la Factura')

@section('content')
<div class="max-w-3xl mx-auto bg-white rounded-xl shadow-md border border-gray-200 p-6">

    {{-- Encabezado --}}
    <div class="flex justify-between items-center border-b border-gray-200 pb-4 mb-6">
        <h2 class="text-2xl font-semibold text-gray-800 flex items-center gap-2">
            🧾 Detalle de la Factura
        </h2>

        <a href="{{ route('facturas.index') }}"
           class="px-3 py-1.5 rounded-lg bg-gray-100 text-gray-800 hover:bg-gray-200 transition">
           ← Volver
        </a>
    </div>

    {{-- Información general --}}
    <div class="grid sm:grid-cols-2 gap-4 text-sm">

        {{-- Número --}}
        <div class="p-4 rounded-lg border border-gray-100 shadow-sm hover:shadow transition">
            <div class="text-gray-500 font-medium">Número de Factura</div>
            <div class="text-gray-900 font-semibold">{{ $factura->invoice_number }}</div>
        </div>

        {{-- Cliente --}}
        <div class="p-4 rounded-lg border border-gray-100 shadow-sm hover:shadow transition">
            <div class="text-gray-500 font-medium">Cliente</div>
            <div class="text-gray-900 font-semibold">{{ $factura->client->name }}</div>
        </div>

        {{-- Fecha --}}
        <div class="p-4 rounded-lg border border-gray-100 shadow-sm hover:shadow transition">
            <div class="text-gray-500 font-medium">Fecha de Emisión</div>
            <div class="text-gray-900 font-semibold">
                {{ \Carbon\Carbon::parse($factura->issued_at)->format('d/m/Y') }}
            </div>
        </div>

        {{-- Estado --}}
        @php
            $estado = strtolower($factura->status);
            $color = match($estado) {
                'emitida' => 'bg-yellow-200 text-yellow-800',
                'pagada'  => 'bg-green-200 text-green-800',
                'anulada' => 'bg-red-200 text-red-800',
                default   => 'bg-gray-200 text-gray-700',
            };
        @endphp

        <div class="p-4 rounded-lg border border-gray-100 shadow-sm hover:shadow transition">
            <div class="text-gray-500 font-medium">Estado</div>
            <span class="px-3 py-1 rounded-lg text-xs font-semibold {{ $color }}">
                {{ ucfirst($factura->status) }}
            </span>

            {{-- Fecha de pago --}}
            @if($factura->paid_at)
                <div class="text-xs text-gray-600 mt-1">
                    Pagada el {{ \Carbon\Carbon::parse($factura->paid_at)->format('d/m/Y H:i') }}
                </div>
            @endif
        </div>

        {{-- Reserva asociada --}}
        @if($factura->reservation)
            <div class="sm:col-span-2 p-4 rounded-lg border border-gray-100 shadow-sm hover:shadow transition">
                <div class="text-gray-500 font-medium">Reserva Asociada</div>
                <div class="text-gray-900 font-semibold">
                    Reserva #{{ $factura->reservation->id }} —
                    {{ $factura->reservation->title ?? 'Sin título' }}
                </div>
            </div>
        @endif

    </div>

    {{-- Ítems --}}
    <div class="mt-8">
        <h3 class="text-lg font-semibold text-gray-800 mb-3">Detalles de Facturación</h3>

        <div class="overflow-hidden rounded-lg border border-gray-300 shadow-sm">
            <table class="w-full text-sm text-left">
                <thead style="background:#2563eb;color:white;">
                    <tr>
                        <th class="px-4 py-3">Descripción</th>
                        <th class="px-4 py-3">Cant.</th>
                        <th class="px-4 py-3">Precio</th>
                        <th class="px-4 py-3">ISV</th>
                        <th class="px-4 py-3">Total</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($factura->items as $item)
                        <tr class="border-b hover:bg-blue-50 transition">
                            <td class="px-4 py-2">{{ $item->description }}</td>
                            <td class="px-4 py-2">{{ $item->quantity }}</td>
                            <td class="px-4 py-2">L. {{ number_format($item->unit_price, 2) }}</td>
                            <td class="px-4 py-2">
                                @switch($item->tax_type)
                                    @case('isv15') 15% @break
                                    @case('isv18') 18% @break
                                    @default Exento
                                @endswitch
                            </td>
                            <td class="px-4 py-2 font-semibold">
                                L. {{ number_format($item->line_total, 2) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>

    {{-- Totales --}}
    <div class="mt-6 grid sm:grid-cols-2 gap-4">
        <div></div>

        <div class="p-4 bg-gray-50 border rounded-lg shadow-sm text-sm space-y-1">
            <div class="flex justify-between">
                <span class="text-gray-600">Subtotal:</span>
                <span class="font-semibold">L. {{ number_format($factura->subtotal, 2) }}</span>
            </div>

            <div class="flex justify-between">
                <span class="text-gray-600">Descuento:</span>
                <span class="font-semibold">L. {{ number_format($factura->discount, 2) }}</span>
            </div>

            <div class="flex justify-between">
                <span class="text-gray-600">ISV 15%:</span>
                <span class="font-semibold">L. {{ number_format($factura->tax_15, 2) }}</span>
            </div>

            <div class="flex justify-between">
                <span class="text-gray-600">ISV 18%:</span>
                <span class="font-semibold">L. {{ number_format($factura->tax_18, 2) }}</span>
            </div>

            <div class="flex justify-between pt-2 border-t">
                <span class="text-gray-800 font-bold">TOTAL:</span>
                <span class="text-gray-900 font-bold">L. {{ number_format($factura->total,2) }}</span>
            </div>
        </div>
    </div>

    {{-- Botones --}}
    <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-200">

        {{-- Botón: Marcar como pagada --}}
        @if($factura->status !== 'pagada')
            <form action="{{ route('facturas.pagar', $factura->id) }}" method="POST">
                @csrf
                <button class="px-5 py-2.5 rounded-lg bg-green-600 text-white font-medium
                               hover:bg-green-700 hover:shadow-md transition">
                    Marcar como Pagada
                </button>
            </form>
        @endif

        {{-- Editar --}}
        <a href="{{ route('facturas.edit', $factura->id) }}"
           class="px-5 py-2.5 rounded-lg bg-blue-600 text-white font-medium
                  hover:bg-blue-700 hover:shadow-md transition">
            Editar
        </a>

        {{-- Volver --}}
        <a href="{{ route('facturas.index') }}"
           class="px-5 py-2.5 rounded-lg bg-gray-100 text-gray-800 font-medium
                  hover:bg-gray-200 transition">
            Volver
        </a>
    </div>

</div>
@endsection
