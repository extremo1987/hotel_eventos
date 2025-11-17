@extends('layouts.app')

@section('title', 'Editar Cliente')

@section('content')
<div class="max-w-2xl mx-auto bg-white rounded-xl shadow-md border border-gray-200 p-6">

    {{-- Encabezado --}}
    <div class="flex justify-between items-center border-b border-gray-200 pb-4 mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">✏️ Editar Cliente</h2>
        <a href="{{ route('clientes.index') }}"
           class="px-3 py-1.5 rounded-lg bg-gray-100 text-gray-800 hover:bg-gray-200 transition">
           ← Volver
        </a>
    </div>

    {{-- Formulario --}}
    <form action="{{ route('clientes.update', $cliente->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- Nombre --}}
        <div>
            <label for="name" class="block text-sm font-medium text-gray-600 mb-1">Nombre completo</label>
            <input id="name" name="name" value="{{ old('name', $cliente->name) }}"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg
                          focus:border-blue-500 focus:ring-2 focus:ring-blue-200
                          shadow-sm outline-none transition"
                   required>
        </div>

        {{-- Teléfono --}}
        <div>
            <label for="phone" class="block text-sm font-medium text-gray-600 mb-1">Teléfono</label>
            <input id="phone" name="phone" value="{{ old('phone', $cliente->phone) }}"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg
                          focus:border-blue-500 focus:ring-2 focus:ring-blue-200
                          shadow-sm outline-none transition">
        </div>

        {{-- Email --}}
        <div>
            <label for="email" class="block text-sm font-medium text-gray-600 mb-1">Correo electrónico</label>
            <input id="email" type="email" name="email" value="{{ old('email', $cliente->email) }}"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg
                          focus:border-blue-500 focus:ring-2 focus:ring-blue-200
                          shadow-sm outline-none transition">
        </div>

        {{-- Botones --}}
        <div class="flex flex-wrap justify-end gap-3 pt-4 border-t border-gray-200">
            <button type="submit"
                    class="px-5 py-2.5 rounded-lg bg-blue-600 text-white font-medium
                           hover:bg-blue-700 hover:shadow-md transition">
                Actualizar
            </button>

            <a href="{{ route('clientes.index') }}"
               class="px-5 py-2.5 rounded-lg bg-gray-100 text-gray-800 font-medium
                      hover:bg-gray-200 transition">
                Cancelar
            </a>
        </div>
    </form>
</div>
@endsection
