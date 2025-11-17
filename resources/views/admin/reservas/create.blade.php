@extends('layouts.app')

@section('title', 'Nueva Reserva')

@section('content')
<div class="max-w-2xl mx-auto bg-white rounded-xl shadow-md border border-gray-200 p-6">

    {{-- Encabezado --}}
    <div class="flex justify-between items-center border-b border-gray-200 pb-4 mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">📅 Registrar Nueva Reserva</h2>

        <a href="{{ route('reservas.index') }}"
           class="px-3 py-1.5 rounded-lg bg-gray-100 text-gray-800 hover:bg-gray-200 transition">
           ← Volver
        </a>
    </div>

    {{-- Formulario --}}
    <form action="{{ route('reservas.store') }}" method="POST" class="space-y-6">
        @csrf

        {{-- Cliente --}}
        <div>
            <label for="client_id" class="block text-sm font-medium text-gray-700 mb-1">Cliente</label>
            <select id="client_id" name="client_id" required
                class="w-full border border-gray-300 rounded-lg px-4 py-2 shadow-sm
                       focus:border-blue-600 focus:ring-2 focus:ring-blue-300 transition">
                <option value="">Seleccione un cliente...</option>
                @foreach($clientes as $c)
                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                @endforeach
            </select>
        </div>

        {{-- Salón --}}
        <div>
            <label for="salon_id" class="block text-sm font-medium text-gray-700 mb-1">Salón</label>
            <select id="salon_id" name="salon_id" required
                class="w-full border border-gray-300 rounded-lg px-4 py-2 shadow-sm
                       focus:border-blue-600 focus:ring-2 focus:ring-blue-300 transition">
                <option value="">Seleccione un salón...</option>
                @foreach($salones as $s)
                    <option value="{{ $s->id }}">{{ $s->name }}</option>
                @endforeach
            </select>
        </div>

        {{-- Fecha --}}
        <div>
            <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Fecha de la reserva</label>
            <input id="date" type="date" name="date" required
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 shadow-sm
                          focus:border-blue-600 focus:ring-2 focus:ring-blue-300 transition">
        </div>

        {{-- Horarios --}}
        <div class="grid sm:grid-cols-2 gap-4">
            <div>
                <label for="start_time" class="block text-sm font-medium text-gray-700 mb-1">Hora de inicio</label>
                <input id="start_time" type="time" name="start_time" required
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 shadow-sm
                              focus:border-blue-600 focus:ring-2 focus:ring-blue-300 transition">
            </div>

            <div>
                <label for="end_time" class="block text-sm font-medium text-gray-700 mb-1">Hora de finalización</label>
                <input id="end_time" type="time" name="end_time" required
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 shadow-sm
                              focus:border-blue-600 focus:ring-2 focus:ring-blue-300 transition">
            </div>
        </div>

        {{-- Estado --}}
        <div>
            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
            <select id="status" name="status" required
                class="w-full border border-gray-300 rounded-lg px-4 py-2 shadow-sm
                       focus:border-blue-600 focus:ring-2 focus:ring-blue-300 transition">
                <option value="Pendiente">Pendiente</option>
                <option value="Confirmada">Confirmada</option>
                <option value="Cancelada">Cancelada</option>
            </select>
        </div>

        {{-- Total --}}
        <div>
            <label for="total" class="block text-sm font-medium text-gray-700 mb-1">Total (opcional)</label>
            <input id="total" type="number" step="0.01" name="total"
                   placeholder="Ej. 15000.00"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 shadow-sm
                          focus:border-blue-600 focus:ring-2 focus:ring-blue-300 transition">
        </div>

        {{-- Botones --}}
        <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
            <button type="submit"
                class="px-5 py-2.5 rounded-lg bg-blue-600 text-white font-medium
                       hover:bg-blue-700 hover:shadow-md transition">
                Guardar
            </button>

            <a href="{{ route('reservas.index') }}"
               class="px-5 py-2.5 rounded-lg bg-gray-100 text-gray-800 font-medium
                      hover:bg-gray-200 transition">
                Cancelar
            </a>
        </div>
    </form>
</div>
@endsection
