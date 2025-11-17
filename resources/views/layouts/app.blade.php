<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Panel') — Hotel & Eventos</title>

    {{-- Tailwind + JS de Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Livewire CSS --}}
    @livewireStyles
</head>

<body class="bg-white text-gray-800">

<div class="flex min-h-screen">

    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-md border-r border-gray-200 flex flex-col">

        <div class="p-4 text-xl font-bold border-b border-gray-200 flex items-center gap-2">
            🏨 <span>Hotel & Eventos</span>
        </div>

        @php
            $links = [
                ['route' => 'admin.dashboard', 'icon' => '🏠', 'label' => 'Dashboard'],
                ['url'   => 'admin/clientes', 'icon' => '👥', 'label' => 'Clientes'],
                ['url'   => 'admin/salones', 'icon' => '🏢', 'label' => 'Salones'],
                ['url'   => 'admin/reservas', 'icon' => '📅', 'label' => 'Reservas'],
                ['url'   => 'admin/cotizaciones', 'icon' => '📝', 'label' => 'Cotizaciones'],
                ['url'   => 'admin/facturas', 'icon' => '💳', 'label' => 'Facturación'],
                ['url'   => 'admin/inventario', 'icon' => '📦', 'label' => 'Inventario'],
                ['url'   => 'admin/paquetes', 'icon' => '🎁', 'label' => 'Paquetes'],
                ['url'   => 'admin/promociones', 'icon' => '🎉', 'label' => 'Promociones'],
                ['url'   => 'admin/personal', 'icon' => '🧑‍🍳', 'label' => 'Personal'],
                ['url'   => 'admin/gastos', 'icon' => '💰', 'label' => 'Gastos'],
                ['route' => 'reportes.index', 'icon' => '📊', 'label' => 'Reportes'],
                ['url' => 'admin/configuracion', 'icon' => '⚙️', 'label' => 'Configuración'],
            ];
        @endphp

        <nav class="flex-1 p-3 space-y-1 text-sm font-medium">
            @foreach ($links as $item)
                <a href="{{ $item['route'] ?? url($item['url']) }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-gray-100 transition">
                    <span>{{ $item['icon'] }}</span>
                    <span>{{ $item['label'] }}</span>
                </a>
            @endforeach
        </nav>

        <form method="POST" action="{{ route('logout') }}" class="p-3 border-t border-gray-200">
            @csrf
            <button class="w-full px-3 py-2 text-left hover:bg-red-600 hover:text-white rounded transition">
                🚪 Cerrar sesión
            </button>
        </form>

    </aside>

    <!-- Contenido principal -->
    <main class="flex-1 bg-white">
    <header class="p-4 bg-white border-b border-gray-200">
        <h1 class="text-lg font-bold">@yield('title')</h1>
    </header>

    <div class="p-6">
        @yield('content')
    </div>
</main>


</div>

{{-- Livewire JS (NO agregar Alpine) --}}
@livewireScripts

</body>
</html>
