<div class="space-y-4">

    {{-- Encabezado principal con botón y buscador --}}
    <div class="flex justify-between items-center mb-4">
        {{-- Título + Botón --}}
        <div class="flex items-center gap-3">
            <h2 class="text-xl font-semibold text-gray-800">Lista de Salones</h2>

            <a href="{{ route('salones.create') }}"
               class="px-4 py-2 rounded-lg font-medium text-white hover:shadow transition"
               style="background:#2563eb;">
                Nuevo Salón
            </a>
        </div>

        {{-- Buscador --}}
        <div class="flex items-center gap-2">
            <span style="color:#2563eb;">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M21 21l-4.35-4.35m1.1-5.4a7.5 7.5 0 11-15 0 7.5 7.5 0 0115 0z"/>
                </svg>
            </span>

            <input type="text"
                   wire:model.live="search"
                   placeholder="Buscar salón..."
                   class="w-64 px-3 py-2 text-sm border border-gray-300 rounded-lg
                          focus:border-blue-500 focus:ring-2 focus:ring-blue-200
                          hover:border-blue-400 transition-all duration-200
                          shadow-sm hover:shadow-md focus:shadow-lg outline-none">
        </div>
    </div>

    {{-- Tabla de datos --}}
    <div class="overflow-hidden rounded-lg border border-gray-300 shadow-md">
        <table class="w-full text-sm text-left border-collapse">
            {{-- Encabezado azul con letras blancas --}}
            <thead style="background:#2563eb;color:white;">
                <tr>
                    <th wire:click="sortBy('name')" class="px-4 py-3 cursor-pointer select-none">Nombre</th>
                    <th wire:click="sortBy('capacity')" class="px-4 py-3 cursor-pointer select-none">Capacidad</th>
                    <th wire:click="sortBy('price')" class="px-4 py-3 cursor-pointer select-none">Precio (L.)</th>
                    <th wire:click="sortBy('location')" class="px-4 py-3 cursor-pointer select-none">Ubicación</th>
                    <th wire:click="sortBy('status')" class="px-4 py-3 cursor-pointer select-none">Estado</th>
                    <th class="px-4 py-3 text-right">Acciones</th>
                </tr>
            </thead>

            {{-- Cuerpo de tabla --}}
            <tbody>
                @forelse ($salones as $s)
                    <tr style="transition:0.15s;" onmouseover="this.style.background='#eff6ff'" onmouseout="this.style.background='white'">
                        <td class="px-4 py-2 text-gray-800 font-medium">{{ $s->name }}</td>
                        <td class="px-4 py-2 text-gray-700">{{ $s->capacity }}</td>
                        <td class="px-4 py-2 text-gray-700">L. {{ number_format($s->price, 2) }}</td>
                        <td class="px-4 py-2 text-gray-700">{{ $s->location }}</td>

                        {{-- Estado visual con color sólido --}}
                        <td class="px-4 py-2">
                            @php
                                $estado = strtolower($s->status);
                                $style = match($estado) {
                                    'disponible'    => 'background:#16a34a;color:white;',
                                    'mantenimiento' => 'background:#eab308;color:white;',
                                    'ocupado'       => 'background:#dc2626;color:white;',
                                    default         => 'background:#6b7280;color:white;',
                                };
                            @endphp
                            <span style="padding:4px 10px;border-radius:9999px;font-size:12px;font-weight:600;{{ $style }}">
                                {{ ucfirst($s->status) }}
                            </span>
                        </td>

                        {{-- Acciones alineadas a la derecha --}}
                        <td class="px-4 py-2 text-right">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('salones.show', $s->id) }}"
                                   class="px-3 py-1.5 rounded-lg bg-gray-100 text-gray-800 hover:bg-gray-200 transition">
                                    Ver
                                </a>

                                <a href="{{ route('salones.edit', $s->id) }}"
                                   class="px-3 py-1.5 rounded-lg text-white hover:shadow transition"
                                   style="background:#2563eb;">
                                    Editar
                                </a>

                                <form action="{{ route('salones.destroy', $s->id) }}" method="POST"
                                      onsubmit="return confirm('¿Eliminar salón {{ $s->name }}?')">
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
                            ⚠️ No hay salones registrados o resultados para "{{ $search }}"
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Paginador --}}
    <div class="pt-2">
        {{ $salones->links() }}
    </div>
</div>
