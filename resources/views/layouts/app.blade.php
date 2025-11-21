<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Panel') — Hotel & Eventos</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles

    <style>
        .sidebar-link {
            transition: 0.25s;
        }
        .sidebar-link:hover {
            background: rgba(0,0,0,0.05);
        }
        .sidebar-active {
            background: #eef2ff !important;
            font-weight: 600;
            color: #4f46e5;
        }
    </style>
</head>

<body class="bg-gray-100 text-gray-800">

<div class="flex min-h-screen">

    {{-- SIDEBAR --}}
    <aside class="w-64 bg-white shadow-md border-r border-gray-200 flex flex-col">

        <div class="p-4 text-xl font-bold border-b flex items-center gap-2">
            🏨 <span>Hotel & Eventos</span>
        </div>

        @php
            $links = [
                ['route' => 'admin.dashboard', 'icon' => '🏠', 'label' => 'Dashboard'],
                ['url'   => 'clientes', 'icon' => '👥', 'label' => 'Clientes'],
                ['url'   => 'salones', 'icon' => '🏢', 'label' => 'Salones'],
                ['url'   => 'reservas', 'icon' => '📅', 'label' => 'Reservas'],
                ['url'   => 'cotizaciones', 'icon' => '📝', 'label' => 'Cotizaciones'],
                ['url'   => 'facturas', 'icon' => '💳', 'label' => 'Facturación'],
                ['url'   => 'inventario', 'icon' => '📦', 'label' => 'Inventario'],
                ['url'   => 'paquetes', 'icon' => '🎁', 'label' => 'Paquetes'],
                ['url'   => 'promociones', 'icon' => '🎉', 'label' => 'Promociones'],
                ['url'   => 'personal', 'icon' => '🧑‍🍳', 'label' => 'Personal'],
                ['url'   => 'gastos', 'icon' => '💰', 'label' => 'Gastos'],
                ['route' => 'reportes.index', 'icon' => '📊', 'label' => 'Reportes'],
                ['url'   => 'configuracion', 'icon' => '⚙️', 'label' => 'Configuración'],
            ];
        @endphp

        <nav class="flex-1 p-3 space-y-1 text-sm font-medium">

            @foreach ($links as $item)
                @php
                    $isActive = isset($item['route'])
                        ? request()->routeIs($item['route'])
                        : request()->is('admin/' . $item['url'] . '*');
                @endphp

                <a href="{{ isset($item['route']) ? route($item['route']) : url('admin/'.$item['url']) }}"
                   class="sidebar-link flex items-center gap-3 px-3 py-2 rounded-md
                        {{ $isActive ? 'sidebar-active' : '' }}">
                    <span>{{ $item['icon'] }}</span>
                    <span>{{ $item['label'] }}</span>
                </a>
            @endforeach

        </nav>

        <form method="POST" action="{{ route('logout') }}" class="p-3 border-t">
            @csrf
            <button class="w-full px-3 py-2 text-left hover:bg-red-600 hover:text-white rounded transition">
                🚪 Cerrar sesión
            </button>
        </form>

    </aside>

    {{-- CONTENT --}}
    <main class="flex-1">

        <header class="p-4 bg-white border-b shadow-sm flex justify-between items-center">
            <h1 class="text-lg font-bold">@yield('title')</h1>

            <div class="flex items-center gap-4">
                <span class="text-gray-700">{{ auth()->user()->name ?? 'Admin' }}</span>
                <span class="text-2xl">👤</span>
            </div>
        </header>

        <div class="p-6">
            @yield('content')
        </div>

    </main>

</div>

@livewireScripts
</body>
</html>
