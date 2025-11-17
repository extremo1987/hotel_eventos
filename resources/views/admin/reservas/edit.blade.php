@extends('layouts.app')

@section('title', 'Editar Reserva')

@section('content')
<div class="max-w-xl mx-auto bg-white rounded-xl shadow border border-gray-200 p-6">

    {{-- Encabezado --}}
    <div class="flex justify-between items-center border-b border-gray-200 pb-4 mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">✏️ Editar Reserva</h2>
        <a href="{{ route('reservas.index') }}"
           class="px-3 py-1.5 rounded-lg bg-gray-100 text-gray-800 hover:bg-gray-200 transition">
           ← Volver
        </a>
    </div>

    {{-- Formulario --}}
    <form action="{{ route('reservas.update', $reserva->id) }}" method="POST" class="space-y-5">
        @csrf
        @method('PUT')

        {{-- Cliente --}}
        <div>
            <label for="client_id" class="block text-sm text-gray-700 mb-1">Cliente</label>
            <select id="client_id" name="client_id" required
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-200 focus:border-blue-500 outline-none transition">
                <option value="">Seleccione un cliente...</option>
                @foreach($clientes as $c)
                    <option value="{{ $c->id }}" {{ $reserva->client_id == $c->id ? 'selected' : '' }}>
                        {{ $c->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Salón --}}
        <div>
            <label for="salon_id" class="block text-sm text-gray-700 mb-1">Salón</label>
            <select id="salon_id" name="salon_id" required
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-200 focus:border-blue-500 outline-none transition">
                <option value="">Seleccione un salón...</option>
                @foreach($salones as $s)
                    <option value="{{ $s->id }}" {{ $reserva->salon_id == $s->id ? 'selected' : '' }}>
                        {{ $s->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Título --}}
        <div>
            <label for="title" class="block text-sm text-gray-700 mb-1">Título / Evento</label>
            <input id="title" type="text" name="title" value="{{ old('title', $reserva->title) }}"
                placeholder="Ej. Boda de Carlos y Ana"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-200 focus:border-blue-500 outline-none transition">
        </div>

        {{-- Fecha y horas --}}
        <div class="grid sm:grid-cols-2 gap-4">
            <div>
                <label for="start_at" class="block text-sm text-gray-700 mb-1">Inicio</label>
                <input id="start_at" type="datetime-local" name="start_at"
                    value="{{ old('start_at', \Carbon\Carbon::parse($reserva->start_at)->format('Y-m-d\TH:i')) }}"
                    required
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-200 focus:border-blue-500 outline-none transition">
            </div>

            <div>
                <label for="end_at" class="block text-sm text-gray-700 mb-1">Finalización</label>
                <input id="end_at" type="datetime-local" name="end_at"
                    value="{{ old('end_at', \Carbon\Carbon::parse($reserva->end_at)->format('Y-m-d\TH:i')) }}"
                    required
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-200 focus:border-blue-500 outline-none transition">
            </div>
        </div>

        {{-- Estado --}}
        <div>
            <label for="status" class="block text-sm text-gray-700 mb-1">Estado</label>
            <select id="status" name="status" required
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-200 focus:border-blue-500 outline-none transition">
                <option value="Pendiente"  {{ $reserva->status == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                <option value="Confirmada" {{ $reserva->status == 'Confirmada' ? 'selected' : '' }}>Confirmada</option>
                <option value="Cancelada"  {{ $reserva->status == 'Cancelada' ? 'selected' : '' }}>Cancelada</option>
            </select>
        </div>

        {{-- Total --}}
        <div>
            <label for="total" class="block text-sm text-gray-700 mb-1">Total (L.)</label>
            <input id="total" type="number" step="0.01" name="total" value="{{ old('total', $reserva->total) }}"
                placeholder="Ej. 15000.00"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-200 focus:border-blue-500 outline-none transition">
        </div>

        {{-- Botones --}}
        <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
            <button type="submit"
                class="px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 hover:shadow-sm transition">
                Guardar Cambios
            </button>

            <a href="{{ route('reservas.index') }}"
                class="px-4 py-2 rounded-lg bg-gray-100 text-gray-800 hover:bg-gray-200 transition">
                Cancelar
            </a>
        </div>
    </form>
</div>
@endsection
