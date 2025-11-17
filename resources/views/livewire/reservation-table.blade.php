<div class="space-y-4">

    {{-- Encabezado principal con botón y buscador --}}
    <div class="flex justify-between items-center mb-4">
        {{-- Título + Botón --}}
        <div class="flex items-center gap-3">
            <h2 class="text-xl font-semibold text-gray-800">Lista de Reservas</h2>

            <a href="{{ route('reservas.create') }}"
               class="px-4 py-2 rounded-lg font-medium text-white hover:shadow transition"
               style="background:#2563eb;">
                Nuevo Reserva
            </a>
        </div>

    {{-- Lado derecho: buscador --}}
    <div class="flex items-center gap-2">
        {{-- Icono lupa --}}
        <span style="color:#2563eb;">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M21 21l-4.35-4.35m1.1-5.4a7.5 7.5 0 11-15 0 7.5 7.5 0 0115 0z"/>
            </svg>
        </span>

        {{-- Campo de búsqueda --}}
        <input type="text"
               wire:model.live="search"
               placeholder="Buscar reserva..."
               class="w-64 px-3 py-2 text-sm border border-gray-300 rounded-lg
                      focus:border-blue-500 focus:ring-2 focus:ring-blue-200
                      hover:border-blue-400 transition-all duration-200
                      shadow-sm hover:shadow-md focus:shadow-lg outline-none">
    </div>
</div>


    {{-- Tabla --}}
    <div class="overflow-hidden rounded-lg border border-gray-300 shadow-md">
        <table class="w-full text-sm text-left border-collapse">
            {{-- Encabezado azul --}}
            <thead style="background:#2563eb;color:white;">
                <tr>
                    <th wire:click="sortBy('id')" class="px-4 py-3 cursor-pointer select-none">#</th>
                    <th wire:click="sortBy('client_id')" class="px-4 py-3 cursor-pointer select-none">Cliente</th>
                    <th wire:click="sortBy('salon_id')" class="px-4 py-3 cursor-pointer select-none">Salón</th>
                    <th wire:click="sortBy('status')" class="px-4 py-3 cursor-pointer select-none">Estado</th>
                    <th wire:click="sortBy('total')" class="px-4 py-3 cursor-pointer select-none">Total (L.)</th>
                    <th class="px-4 py-3 text-right">Acciones</th>
                </tr>
            </thead>

            {{-- Cuerpo --}}
            <tbody>
                @forelse ($reservas as $r)
                    <tr style="transition:0.15s;" onmouseover="this.style.background='#eff6ff'" onmouseout="this.style.background='white'">
                        <td class="px-4 py-2 text-gray-800">{{ $r->id }}</td>
                        <td class="px-4 py-2 text-gray-800">{{ $r->client->name ?? '—' }}</td>
                        <td class="px-4 py-2 text-gray-800">{{ $r->salon->name ?? '—' }}</td>
                        <td class="px-4 py-2">
                            @php
                                $estado = strtolower($r->status);
                                $style = match($estado) {
                                    'confirmada' => 'background:#16a34a;color:white;',
                                    'pendiente'  => 'background:#eab308;color:white;',
                                    'cancelada'  => 'background:#dc2626;color:white;',
                                    default      => 'background:#6b7280;color:white;',
                                };
                            @endphp
                            <span style="padding:4px 10px;border-radius:9999px;font-size:12px;font-weight:600;{{ $style }}">
                                {{ ucfirst($r->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-2 text-gray-800">L. {{ number_format($r->total, 2) }}</td>

                        <td class="px-4 py-2 text-right">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('reservas.show', $r->id) }}"
                                   class="px-3 py-1.5 rounded-lg bg-gray-100 text-gray-800 hover:bg-gray-200 transition">
                                    Ver
                                </a>

                                <a href="{{ route('reservas.edit', $r->id) }}"
                                   class="px-3 py-1.5 rounded-lg text-white hover:shadow transition"
                                   style="background:#2563eb;">
                                    Editar
                                </a>

                                <form action="{{ route('reservas.destroy', $r->id) }}" method="POST"
                                      onsubmit="return confirm('¿Eliminar reserva #{{ $r->id }}?')"
                                      class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button class="px-3 py-1.5 rounded-lg text-white hover:shadow transition"
                                            style="background:#dc2626;">
                                        Eliminar
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-6 text-center text-gray-500">
                            ⚠️ No hay resultados para "<strong>{{ $search }}</strong>"
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Paginación --}}
    <div class="pt-2">
        {{ $reservas->links() }}
    </div>

</div>
