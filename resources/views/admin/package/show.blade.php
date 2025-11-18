@extends('layouts.app')

@section('title', 'Detalles del Paquete')

@section('content')
<div class="max-w-3xl mx-auto bg-white rounded-xl shadow-md border border-gray-200 p-6">

    {{-- Encabezado --}}
    <div class="flex justify-between items-center border-b border-gray-200 pb-4 mb-6">
        <h2 class="text-2xl font-semibold text-gray-800 flex items-center gap-2">
            🎁 Detalles del Paquete
        </h2>

        <a href="{{ route('paquetes.index') }}"
           class="px-3 py-1.5 rounded-lg bg-gray-100 text-gray-800 hover:bg-gray-200 transition">
           ← Volver
        </a>
    </div>

    {{-- Información principal --}}
    <div class="grid sm:grid-cols-2 gap-4 text-sm">

        <div class="p-4 rounded-lg bg-gray-50 border border-gray-200 shadow-sm hover:shadow transition">
            <div class="text-gray-500 font-medium">Nombre del paquete</div>
            <div class="text-gray-900 font-semibold">{{ $paquete->name }}</div>
        </div>

        <div class="p-4 rounded-lg bg-gray-50 border border-gray-200 shadow-sm hover:shadow transition">
            <div class="text-gray-500 font-medium">Categoría</div>
            <div class="text-gray-900 font-semibold">{{ $paquete->category }}</div>
        </div>

        <div class="p-4 rounded-lg bg-gray-50 border border-gray-200 shadow-sm hover:shadow transition">
            <div class="text-gray-500 font-medium">Precio base</div>
            <div class="text-gray-900 font-semibold">L. {{ number_format($paquete->price,2) }}</div>
        </div>

        <div class="p-4 rounded-lg bg-gray-50 border border-gray-200 shadow-sm hover:shadow transition">
            <div class="text-gray-500 font-medium">Estado</div>
            <span class="text-white text-xs px-3 py-1 rounded-full
                @if($paquete->is_active)
                    bg-green-600
                @else
                    bg-red-600
                @endif">
                {{ $paquete->is_active ? 'Activo' : 'Inactivo' }}
            </span>
        </div>

        <div class="p-4 rounded-lg bg-gray-50 border border-gray-200 shadow-sm hover:shadow transition sm:col-span-2">
            <div class="text-gray-500 font-medium">Descripción</div>
            <div class="text-gray-900 font-semibold">
                {{ $paquete->description ?: '—' }}
            </div>
        </div>

        {{-- Menú de comida --}}
        <div class="p-4 rounded-lg bg-gray-50 border border-gray-200 shadow-sm hover:shadow transition sm:col-span-2">
            <div class="text-gray-500 font-medium">Menú incluido</div>

            @if($paquete->menu && count($paquete->menu))
                <ul class="list-disc ml-5 text-gray-800">
                    @foreach($paquete->menu as $item)
                        <li>{{ $item }}</li>
                    @endforeach
                </ul>
            @else
                <div class="text-gray-600 italic">No se agregó menú</div>
            @endif
        </div>

    </div>

    {{-- Botones --}}
    <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-200">
        <a href="{{ route('paquetes.edit', $paquete->id) }}"
           class="px-5 py-2.5 rounded-lg bg-blue-600 text-white font-medium
                  hover:bg-blue-700 hover:shadow">
            Editar
        </a>

        <a href="{{ route('paquetes.index') }}"
           class="px-5 py-2.5 rounded-lg bg-gray-100 text-gray-800 font-medium
                  hover:bg-gray-200">
            Volver
        </a>
    </div>

</div>
@endsection
