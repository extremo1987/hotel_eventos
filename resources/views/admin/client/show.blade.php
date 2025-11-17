@extends('layouts.app')

@section('title', 'Detalles del Cliente')

@section('content')
<div class="max-w-2xl mx-auto bg-white rounded-xl shadow-md border border-gray-200 p-6">

    {{-- Encabezado --}}
    <div class="flex justify-between items-center border-b border-gray-200 pb-4 mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">👤 Detalles del Cliente</h2>

        <a href="{{ route('clientes.index') }}"
           class="px-3 py-1.5 rounded-lg bg-gray-100 text-gray-800 hover:bg-gray-200 transition">
           ← Volver
        </a>
    </div>

    {{-- Información del Cliente --}}
    <div class="grid sm:grid-cols-2 gap-4 text-sm">
        <div class="p-4 rounded-lg border border-gray-100 shadow-sm hover:shadow transition">
            <div class="text-gray-500 font-medium">Nombre completo</div>
            <div class="text-gray-900 font-semibold">{{ $cliente->name ?: '—' }}</div>
        </div>

        <div class="p-4 rounded-lg border border-gray-100 shadow-sm hover:shadow transition">
            <div class="text-gray-500 font-medium">Teléfono</div>
            <div class="text-gray-900 font-semibold">{{ $cliente->phone ?: '—' }}</div>
        </div>

        <div class="p-4 rounded-lg border border-gray-100 shadow-sm hover:shadow transition sm:col-span-2">
            <div class="text-gray-500 font-medium">Correo electrónico</div>
            <div class="text-gray-900 font-semibold">{{ $cliente->email ?: '—' }}</div>
        </div>

        <div class="p-4 rounded-lg border border-gray-100 shadow-sm hover:shadow transition sm:col-span-2">
            <div class="text-gray-500 font-medium">Fecha de registro</div>
            <div class="text-gray-900 font-semibold">
                {{ $cliente->created_at ? $cliente->created_at->format('d/m/Y H:i') : '—' }}
            </div>
        </div>
    </div>

    {{-- Botones de acción --}}
    <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-200">
        <a href="{{ route('clientes.edit', $cliente->id) }}"
           class="px-5 py-2.5 rounded-lg bg-blue-600 text-white font-medium
                  hover:bg-blue-700 hover:shadow-md transition">
            Editar
        </a>

        <a href="{{ route('clientes.index') }}"
           class="px-5 py-2.5 rounded-lg bg-gray-100 text-gray-800 font-medium
                  hover:bg-gray-200 transition">
            Volver
        </a>
    </div>
</div>
@endsection
