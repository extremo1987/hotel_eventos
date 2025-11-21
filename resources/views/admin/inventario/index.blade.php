@extends('layouts.app')

@section('title','Inventario')

@section('content')
<div class="grid md:grid-cols-4 gap-4 mb-4">
    <div class="bg-white p-4 rounded shadow">
        <div class="text-sm text-gray-500">Valor total</div>
        <div class="text-2xl font-bold">L {{ number_format($totalValue,2) }}</div>
    </div>
    <div class="bg-white p-4 rounded shadow">
        <div class="text-sm text-gray-500">Bajo stock</div>
        <div class="text-2xl font-bold">{{ $lowStockCount }}</div>
    </div>
    <div class="bg-white p-4 rounded shadow">
        <div class="text-sm text-gray-500">Agotados</div>
        <div class="text-2xl font-bold">{{ $outOfStockCount }}</div>
    </div>
    <div class="bg-white p-4 rounded shadow text-right">
        <a href="{{ route('admin.inventario.create') }}" class="btn-blue">Nuevo artículo</a>
        <a href="{{ route('admin.inventario.export') }}" class="btn-gray ml-2">Exportar CSV</a>
    </div>
</div>

<div class="bg-white rounded shadow p-4">
    <form class="flex gap-2 mb-4" method="GET" action="{{ route('admin.inventario.index') }}">
        <input name="q" value="{{ request('q') }}" placeholder="Buscar por nombre o sku" class="border p-2 rounded flex-1">
        <select name="category" class="border p-2 rounded">
            <option value="">Todas las categorías</option>
            {{-- podrías cargar categorías reales --}}
        </select>
        <button class="btn-blue">Buscar</button>
    </form>

    <div class="overflow-x-auto">
    <table class="table-ui w-full">
        <thead>
            <tr>
                <th>SKU</th><th>Producto</th><th>Categoría</th><th>Stock</th><th>Mínimo</th><th>Precio</th><th>Estado</th><th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
            <tr>
                <td>{{ $item->sku }}</td>
                <td><a href="{{ route('admin.inventario.show',$item) }}" class="font-semibold">{{ $item->name }}</a></td>
                <td>{{ $item->category }}</td>
                <td>
                    {{ $item->quantity }}
                    @if($item->isLowStock())
                        <span class="text-yellow-600 ml-2">⚠ Bajo</span>
                    @endif
                </td>
                <td>{{ $item->min_stock }}</td>
                <td>L {{ number_format($item->unit_price ?? 0,2) }}</td>
                <td>{{ $item->is_active ? 'Activo' : 'Inactivo' }}</td>
                <td class="text-right">
                    <a href="{{ route('admin.inventario.edit',$item) }}" class="btn-gray">Editar</a>
                    <a href="{{ route('admin.inventario.movements', $item) }}" class="btn-blue">Movimientos</a>
                    <form action="{{ route('admin.inventario.destroy',$item) }}" method="POST" style="display:inline">
                        @csrf @method('DELETE')
                        <button class="btn-red" onclick="return confirm('Eliminar?')">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>

    <div class="mt-4">
        {{ $items->withQueryString()->links() }}
    </div>
</div>
@endsection
