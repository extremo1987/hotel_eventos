@extends('layouts.app')

@section('title', 'Editar Salón')

@section('content')
<div class="max-w-2xl mx-auto bg-white rounded-xl shadow-md border border-gray-200 p-6">

    {{-- Encabezado --}}
    <div class="flex justify-between items-center border-b border-gray-200 pb-4 mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">🏢 Editar Salón</h2>
        

        <a href="{{ route('salones.index') }}"
           class="px-3 py-1.5 rounded-lg bg-gray-100 text-gray-800 hover:bg-gray-200 transition">
           ← Volver
        </a>
    </div>

    {{-- Formulario --}}
    <form action="{{ route('salones.update', $salon->id) }}" method="POST" class="space-y-5">
        @csrf
        @method('PUT')

        {{-- Nombre --}}
        <div>
            <label class="block text-sm font-medium text-gray-600 mb-1">Nombre</label>
            <input type="text" name="name" value="{{ old('name', $salon->name) }}" required
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm
                          focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition"
                   placeholder="Ej. Gran Salón Imperial">
        </div>

        {{-- Capacidad --}}
        <div>
            <label class="block text-sm font-medium text-gray-600 mb-1">Capacidad</label>
            <input type="number" name="capacity" value="{{ old('capacity', $salon->capacity) }}"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm
                          focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition"
                   placeholder="Ej. 250">
        </div>

        {{-- Precio --}}
        <div>
            <label class="block text-sm font-medium text-gray-600 mb-1">Precio (L.)</label>
            <input type="number" step="0.01" name="price" value="{{ old('price', $salon->price) }}"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm
                          focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition"
                   placeholder="Ej. 15000.00">
        </div>

        {{-- Ubicación --}}
        <div>
            <label class="block text-sm font-medium text-gray-600 mb-1">Ubicación</label>
            <input type="text" name="location" value="{{ old('location', $salon->location) }}"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm
                          focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition"
                   placeholder="Ej. Edificio Principal">
        </div>

        {{-- Tarifa / Tipo --}}
        <div>
            <label class="block text-sm font-medium text-gray-600 mb-1">Tarifa / Tipo</label>
            <input type="text" name="rate" value="{{ old('rate', $salon->rate) }}"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm
                          focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition"
                   placeholder="Ej. Premium / Estándar / VIP">
        </div>

        {{-- Estado --}}
        <div>
            <label class="block text-sm font-medium text-gray-600 mb-1">Estado</label>
            <select name="status"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm
                           focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition">
                <option value="Disponible" {{ $salon->status == 'Disponible' ? 'selected' : '' }}>Disponible</option>
                <option value="Ocupado" {{ $salon->status == 'Ocupado' ? 'selected' : '' }}>Ocupado</option>
                <option value="Mantenimiento" {{ $salon->status == 'Mantenimiento' ? 'selected' : '' }}>Mantenimiento</option>
            </select>
        </div>

        {{-- Notas --}}
        <div>
            <label class="block text-sm font-medium text-gray-600 mb-1">Notas</label>
            <textarea name="notes" rows="3"
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm
                             focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition"
                      placeholder="Observaciones o detalles adicionales...">{{ old('notes', $salon->notes) }}</textarea>
        </div>

        {{-- Botones --}}
        <div class="flex flex-wrap justify-end gap-3 pt-4 border-t border-gray-200">
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
