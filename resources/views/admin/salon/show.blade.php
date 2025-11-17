@extends('layouts.app')

@section('title', 'Detalles del Salón')

@section('content')
<div class="max-w-2xl mx-auto bg-white rounded-xl shadow-md border border-gray-200 p-6">

    {{-- Encabezado --}}
    <div class="flex justify-between items-center border-b border-gray-200 pb-4 mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">🏢 Detalles del Salón</h2>

        <a href="{{ route('salones.index') }}"
           class="px-3 py-1.5 rounded-lg bg-gray-100 text-gray-800 hover:bg-gray-200 transition">
           ← Volver
        </a>
    </div>

    {{-- Información del Salón --}}
    <div class="grid sm:grid-cols-2 gap-4 text-sm">
        <div class="p-4 rounded-lg border border-gray-100 shadow-sm hover:shadow transition">
            <div class="text-gray-500 font-medium">Nombre</div>
            <div class="text-gray-900 font-semibold">{{ $salon->name }}</div>
        </div>

        <div class="p-4 rounded-lg border border-gray-100 shadow-sm hover:shadow transition">
            <div class="text-gray-500 font-medium">Capacidad</div>
            <div class="text-gray-900 font-semibold">{{ $salon->capacity ?: '—' }}</div>
        </div>

        <div class="p-4 rounded-lg border border-gray-100 shadow-sm hover:shadow transition">
            <div class="text-gray-500 font-medium">Precio (L.)</div>
            <div class="text-gray-900 font-semibold">L. {{ number_format($salon->price, 2) }}</div>
        </div>

        <div class="p-4 rounded-lg border border-gray-100 shadow-sm hover:shadow transition">
            <div class="text-gray-500 font-medium">Ubicación</div>
            <div class="text-gray-900 font-semibold">{{ $salon->location ?: '—' }}</div>
        </div>

        <div class="p-4 rounded-lg border border-gray-100 shadow-sm hover:shadow transition">
            <div class="text-gray-500 font-medium">Tarifa / Tipo</div>
            <div class="text-gray-900 font-semibold">{{ $salon->rate ?: '—' }}</div>
        </div>

        <div class="p-4 rounded-lg border border-gray-100 shadow-sm hover:shadow transition">
            <div class="text-gray-500 font-medium">Estado</div>
            <div>
                @if($salon->status == 'Disponible')
                    <span class="px-3 py-1 rounded-lg text-xs font-semibold bg-green-200 text-green-800">
                        Disponible
                    </span>
                @elseif($salon->status == 'Mantenimiento')
                    <span class="px-3 py-1 rounded-lg text-xs font-semibold bg-yellow-200 text-yellow-800">
                        Mantenimiento
                    </span>
                @else
                    <span class="px-3 py-1 rounded-lg text-xs font-semibold bg-red-200 text-red-800">
                        Ocupado
                    </span>
                @endif
            </div>
        </div>

        <div class="sm:col-span-2 p-4 rounded-lg border border-gray-100 shadow-sm hover:shadow transition">
            <div class="text-gray-500 font-medium">Notas</div>
            <div class="text-gray-800 whitespace-pre-line">{{ $salon->notes ?: '—' }}</div>
        </div>
    </div>

    {{-- Botones de acción --}}
    <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-200">
        <a href="{{ route('salones.edit', $salon->id) }}"
           class="px-5 py-2.5 rounded-lg bg-blue-600 text-white font-medium
                  hover:bg-blue-700 hover:shadow-md transition">
            Editar
        </a>

        <a href="{{ route('salones.index') }}"
           class="px-5 py-2.5 rounded-lg bg-gray-100 text-gray-800 font-medium
                  hover:bg-gray-200 transition">
            Volver
        </a>
    </div>
</div>
@endsection
