@extends('layouts.app')

@section('title', 'Nuevo Cliente')

@section('content')
<div class="max-w-2xl mx-auto bg-white rounded-xl shadow-md border border-gray-200 p-6">

    {{-- Encabezado --}}
    <div class="flex justify-between items-center border-b border-gray-200 pb-4 mb-6">
        <h2 class="text-2xl font-semibold text-gray-800 flex items-center">
            {{-- Ícono de persona claro y reconocible --}}
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                 fill="currentColor" class="w-6 h-6 text-blue-600 mr-2">
                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
            </svg>
            Nuevo Cliente
        </h2>

        <a href="{{ route('clientes.index') }}"
           class="px-3 py-1.5 rounded-lg bg-gray-100 text-gray-800 hover:bg-gray-200 transition">
           ← Volver
        </a>
    </div>

    {{-- Formulario --}}
    <form action="{{ route('clientes.store') }}" method="POST" class="space-y-6">
        @csrf

        <div>
            <label for="name" class="block text-sm font-medium text-gray-600 mb-1">Nombre completo</label>
            <input id="name" name="name" required
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm
                          focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition"
                   placeholder="Ej. Juan Pérez">
        </div>

        <div>
            <label for="phone" class="block text-sm font-medium text-gray-600 mb-1">Teléfono</label>
            <input id="phone" name="phone"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm
                          focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition"
                   placeholder="Ej. 9999-9999">
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-600 mb-1">Correo electrónico</label>
            <input id="email" type="email" name="email"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm
                          focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition"
                   placeholder="ejemplo@correo.com">
        </div>

        {{-- Botones --}}
        <div class="flex flex-wrap justify-end gap-3 pt-4 border-t border-gray-200">
            <button type="submit"
                    class="px-5 py-2.5 rounded-lg bg-blue-600 text-white font-medium
                           hover:bg-blue-700 hover:shadow-md transition">
                Guardar
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
