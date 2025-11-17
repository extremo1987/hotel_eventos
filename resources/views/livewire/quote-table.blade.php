<div class="space-y-4">

    {{-- Encabezado con buscador --}}
    <div class="flex justify-between items-center mb-4">

        <div class="flex items-center gap-3">
            <h2 class="text-xl font-semibold text-gray-800">Listado de Cotizaciones</h2>

            <a href="{{ route('cotizaciones.create') }}"
               class="px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 hover:shadow transition">
                Nueva Cotización
            </a>
        </div>

        <div class="flex items-center gap-2">
            <span class="text-blue-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M21 21l-4.35-4.35m1.1-5.4a7.5 7.5 0 11-15 0 7.5 7.5 0 0115 0z"/>
                </svg>
            </span>

            <input type="text"
                   wire:model.live="search"
                   placeholder="Buscar cotización..."
                   class="w-64 px-3 py-2 text-sm border border-gray-300 rounded-lg
                          focus:border-blue-500 focus:ring-2 focus:ring-blue-200
                          hover:border-blue-400 transition-all duration-200
                          shadow-sm hover:shadow-md focus:shadow-lg outline-none">
        </div>
    </div>

    {{-- Tabla --}}
    <div class="overflow-hidden rounded-lg border border-gray-300 shadow-md">
        <table class="w-full text-sm text-left border-collapse">
            <thead style="background:#2563eb;color:white;">
                <tr>
                    <th wire:click="sortBy('reference')" class="px-4 py-3 cursor-pointer select-none">Referencia</th>
                    <th wire:click="sortBy('client_id')" class="px-4 py-3 cursor-pointer select-none">Cliente</th>
                    <th wire:click="sortBy('total')" class="px-4 py-3 cursor-pointer select-none">Total</th>
                    <th wire:click="sortBy('status')" class="px-4 py-3 cursor-pointer select-none">Estado</th>
                    <th wire:click="sortBy('valid_until')" class="px-4 py-3 cursor-pointer select-none">Válido hasta</th>
                    <th class="px-4 py-3 text-right">Acciones</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($cotizaciones as $q)
                    <tr style="transition:0.15s;" 
                        onmouseover="this.style.background='#eff6ff'" 
                        onmouseout="this.style.background='white'">

                        {{-- REFERENCIA --}}
                        <td class="px-4 py-2 text-gray-800 font-medium">
                            {{ $q->reference }}
                        </td>

                        {{-- CLIENTE --}}
                        <td class="px-4 py-2 text-gray-700">
                            {{ $q->client->name ?? '—' }}
                        </td>

                        {{-- TOTAL --}}
                        <td class="px-4 py-2 text-gray-700">
                            L. {{ number_format($q->total, 2) }}
                        </td>

                     
                        {{-- ESTADO --}}
<td class="px-4 py-2 text-gray-700">

    @php
        $estado = strtolower($q->status ?? '');

        // Colores sólidos tipo "Salones"
        $style = match($estado) {
            'borrador'  => 'background:#6b7280;color:white;',     // gris
            'enviada'   => 'background:#3b82f6;color:white;',     // azul
            'aceptada'  => 'background:#16a34a;color:white;',     // verde
            'rechazada' => 'background:#dc2626;color:white;',     // rojo
            'vencida'   => 'background:#eab308;color:white;',     // amarillo/ámbar
            default     => 'background:#6b7280;color:white;',     // gris default
        };
    @endphp

    <span style="padding:4px 10px;border-radius:9999px;
                 font-size:12px;font-weight:600;{{ $style }}">
        {{ ucfirst($q->status) }}
    </span>

</td>


                        {{-- FECHA LÍMITE --}}
                        <td class="px-4 py-2 text-gray-700">
                            {{ $q->valid_until
                                ? \Carbon\Carbon::parse($q->valid_until)->format('d/m/Y')
                                : '—'
                            }}
                        </td>

                        {{-- ACCIONES --}}
                        <td class="px-4 py-2 text-right">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('cotizaciones.show', $q->id) }}"
                                   class="px-3 py-1.5 rounded-lg bg-gray-100 text-gray-800 hover:bg-gray-200 transition">
                                   Ver
                                </a>

                                <a href="{{ route('cotizaciones.edit', $q->id) }}"
                                   class="px-3 py-1.5 rounded-lg text-white hover:shadow transition"
                                   style="background:#2563eb;">
                                   Editar
                                </a>

                                <form action="{{ route('cotizaciones.destroy', $q->id) }}" method="POST"
                                      onsubmit="return confirm('¿Eliminar la cotización {{ $q->reference }}?')"
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
        {{ $cotizaciones->links() }}
    </div>
</div>
