@extends('layouts.app')

@section('title', 'Registrar Nuevo Salón')

@section('content')
<div class="max-w-2xl mx-auto bg-white rounded-xl shadow-md border border-gray-200 p-6">

    {{-- Encabezado --}}
    <div class="flex justify-between items-center border-b border-gray-200 pb-4 mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">🏢 Registrar Nuevo Salón</h2>

        <a href="{{ route('salones.index') }}"
           class="px-3 py-1.5 rounded-lg bg-gray-100 text-gray-800 hover:bg-gray-200 transition">
           ← Volver
        </a>
    </div>

    {{-- Formulario --}}
    <form action="{{ route('salones.store') }}" method="POST" class="space-y-5">
        @csrf

        {{-- Nombre --}}
        <div>
            <label for="name" class="block text-sm font-medium text-gray-600 mb-1">Nombre del salón</label>
            <input id="name" type="text" name="name" required
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 shadow-sm
                          focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition"
                   placeholder="Ej. Gran Salón Imperial">
        </div>

        {{-- Capacidad --}}
        <div>
            <label for="capacity" class="block text-sm font-medium text-gray-600 mb-1">Capacidad</label>
            <input id="capacity" type="number" name="capacity"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 shadow-sm
                          focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition"
                   placeholder="Ej. 250">
        </div>

        {{-- Precio --}}
        <div>
            <label for="price" class="block text-sm font-medium text-gray-600 mb-1">Precio (L.)</label>
            <input id="price" type="number" step="0.01" name="price"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 shadow-sm
                          focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition"
                   placeholder="Ej. 15000.00">
        </div>

        {{-- Ubicación --}}
        <div>
            <label for="location" class="block text-sm font-medium text-gray-600 mb-1">Ubicación</label>
            <input id="location" type="text" name="location"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 shadow-sm
                          focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition"
                   placeholder="Ej. Edificio Principal, Segundo Piso">
        </div>

        {{-- Tarifa / Tipo --}}
        <div>
            <label for="rate" class="block text-sm font-medium text-gray-600 mb-1">Tarifa o tipo</label>
            <input id="rate" type="text" name="rate"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 shadow-sm
                          focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition"
                   placeholder="Ej. Premium / Estándar / VIP">
        </div>

        {{-- Estado --}}
        <div>
            <label for="status" class="block text-sm font-medium text-gray-600 mb-1">Estado</label>
            <select id="status" name="status"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 shadow-sm
                           focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition">
                <option value="Disponible">Disponible</option>
                <option value="Ocupado">Ocupado</option>
                <option value="Mantenimiento">Mantenimiento</option>
            </select>
        </div>

        {{-- Notas --}}
        <div>
            <label for="notes" class="block text-sm font-medium text-gray-600 mb-1">Notas</label>
            <textarea id="notes" name="notes" rows="3"
                      class="w-full border border-gray-300 rounded-lg px-4 py-2 shadow-sm
                             focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition"
                      placeholder="Observaciones o detalles adicionales..."></textarea>
        </div>

        {{-- Botones --}}
        <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
            <button type="submit"
                    class="px-5 py-2.5 rounded-lg bg-blue-600 text-white font-medium
                           hover:bg-blue-700 hover:shadow-md transition">
                Guardar
            </button>

            <a href="{{ route('salones.index') }}"
               class="px-5 py-2.5 rounded-lg bg-gray-100 text-gray-800 font-medium
                      hover:bg-gray-200 transition">
                Cancelar
            </a>
        </div>
    </form>
</div>
@endsection
